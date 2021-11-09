<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;

class SessionsController extends Controller
{
    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        /*$user = User::where('email', $request->email)->first();
        if($user){
            //用户存在 验证密码
            if(Hash::check($request->password, $user->password)){
                dd('登录成功');
            }else{
                dd('密码验证不通过');
            }
        }else{
            //未找到用户
            dd('用户不存在');
        }*/

        if(Auth::attempt($credentials, $request->has('remember'))){
            session()->flash('success', '欢迎回来!');
            return redirect()->route('users.show', [Auth::user()]);
        }else{
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return redirect()->back()->withInput();
        }
    }

    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出');
        return redirect('login');
    }
}
