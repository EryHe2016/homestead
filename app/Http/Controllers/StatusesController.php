<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Auth;

class StatusesController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:200',
        ]);
        Auth::user()->statuses()->create([
            'content' => $request['content']
        ]);

        session()->flash('success', '发布成功');
        return redirect()->back();
    }

    public function destroy(Status $status)
    {
        $this->authorize('destroy', $status);

        $status->delete();

        session()->flash('success', '微博已经成功删除！');
        return redirect()->back();
    }
}
