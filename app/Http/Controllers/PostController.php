<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

//authを使用する
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
    //作成 store
    public function store(Request $request)
    {
        //書込が本文なし(＝画像のみ)のとき
        if (!$request->body) {
            $request->body = 'コメントなし';
        }

        $post = Post::create([
            'user_id' => Auth::id(),
            'thread_id' => $request->thread_id,
            'displayed_post_id' => $request->displayed_post_id,
            'body' => $request->body,
            'has_image' => $request->hasFile('image'),
        ]);

        //スレッドのpost_countをインクリメント
        //modelにリレーションを定義しているからできること
        $post->thread()->increment('post_count');

        //画像があれば
        if ($post->has_image) {
            $request->merge([
                'post_id' => $post->id,
            ]);
            $image_controller = new ImageController();
            $image_controller->store($request);
        }
    }

    //★ポスト取得
    public function index($thread_id)
    {
        $posts = Post::with(['image', 'user'])->where('thread_id', $thread_id)->get();
        return $posts;
    }
}
