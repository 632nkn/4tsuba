<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Thread;
use Faker\Core\Number;
//authを使用する
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        Like::create([
            'user_id' => Auth::id(),
            'post_id' => $request->post_id,
        ]);

        //threadsテーブルのlike_countインクリメント
        $thread = new Thread();
        $thread->incrementLikeCount($request->thread_id);
    }

    public function destroy(Request $request)
    {
        $like = Like::where('user_id', Auth::id())->where('post_id', $request->post_id);
        $like->delete();

        //threadsテーブルのlike_countデクリメント
        $thread = new Thread();
        $thread->decrementLikeCount($request->thread_id);
    }
}
