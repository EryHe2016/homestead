<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Mail;
use Hash;
use DB;

class PasswordController extends Controller
{
    public function __construct()
    {
        //限流 一分钟内只能访问两次 重置密码页面
        $this->middleware('throttle:2,1', [
            'only' => ['showLinkRequestForm']
        ]);
    }

    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        //1. 验证邮箱
        $this->validate($request, [
            'email' => 'required|email'
        ]);
        $email = $request->email;

        //2.获取对应的用户
        $user = User::where('email', $email)->first();

        //3. 用户不存在
        if(is_null($user)){
            session()->flash('danger', '邮箱未注册。');
            return redirect()->back()->withInput();
        }

        //4.生成token,会在视图emails.reset_link里拼接链接
        $token = hash_hmac('sha256', Str::random(40), config('app.key'));

        //5.入库 使用updateOrInsert 来保持email唯一
        DB::table('password_resets')->updateOrInsert(['email'=>$email], [
            'email' => $email,
            'token' => Hash::make($token),
            'created_at' => new Carbon(),
        ]);

        //6.将token链接发动给用户
        Mail::send('emails.reset_link',compact('token'), function($message)use($email){
            $message->to($email)->subject('忘记密码');
        });

        session()->flash('success', '重置邮件发送成功，请查收。');
        return redirect()->back();
    }

    public function showResetForm(Request $request)
    {
        $token = $request->route()->parameter('token');
        return view('auth.passwords.reset', compact('token'));
    }

    public function reset(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);
        $email = $request->email;
        $token = $request->token;
        //找回密码的有效时间
        $expire = 60*10;

        //查找用户
        $user = User::where('email', $email)->first();

        //用户不存在
        if(is_null($user)){
            session()->flash('warning', '未注册邮箱。');
            return redirect()->back()->withInput();
        }

        //获取重置信息
        $record = (array) DB::table('password_reset')->where('email', $email)->first();

        //记录存在
        if($record){
            //验证是否过期
            if(Carbon::parse($record['created_at'])->addSeconds($expire)->isPast()){
                session()->flash('danger', '链接已经过期，请重新尝试。');
                return redirect()->back();
            }

            //验证token是否正确
            if(! Hash::check($token, $record['token'])){
                session()->flash('danger', '令牌错误。');
                return redirect()->back();
            }

            //更新密码
            $user->update(['password'=>bcrypt($request->password)]);

            //更新成功
            session()->flash('success', '密码重置成功，请使用新密码登录');
            return redirect()->route('login');
        }

        //记录不存在
        session()->flash('danger', '未找到重置记录。');
        return redirect()->back();
    }
}
