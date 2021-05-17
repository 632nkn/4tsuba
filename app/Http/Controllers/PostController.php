<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Thread;
use App\Models\Response;

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

        //リクエストにスレッドidを追加
        $temp_post = new Post();
        $request->merge([
            'displayed_post_id' => $temp_post->returnMaxDisplayedPostId($request->thread_id) + 1,
        ]);


        //本文に「>>」を含むなら精査させる
        if (strpos($request->body, '>>') !== false) {
            $response_controller = new ResponseController();
            $response_controller->store($request);
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
    //※query() ：動的にwhere句を生成。=>スレッド個別とユーザープロフィールでこのメソッドを使い回す。
    //クエリパラメータで値を渡す api/posts?where=thread_id&value=2
    public function index(Request $request)
    {
        // $temp_post = new Post();
        // $login_user_post_table = $temp_post->returnLoginUserPostTable($thread_id);


        //select(*)ないと外部結合した列がでなくなるので注意
        $query = Post::query();
        $query->select('*')->with(['thread', 'image', 'user',])->withTrashed()
            //  1がnullになるときがあるバグ
            // ->leftJoinSub($login_user_post_table, 'login_user_post_table', function ($join) {
            //     $join->on('posts.id', '=', 'login_user_post_table.login_user_posted_post_id');
            // })
            ->withCount([
                'likes',
                'likes AS login_user_liked' => function ($query) {
                    $query->where('user_id', Auth::id());
                },
            ])
            ->whereNotNull('user_id');

        if ($request->where == 'thread_id') {
            //スレッド内の返信関係を取得 thread_idを特定しないと掴みようがないため、この位置
            $response = new Response();
            $responded_count_table = $response->returnRespondedCountTable($request->value);

            $query->leftJoinSub($responded_count_table, 'responded_count_table', function ($join) {
                $join->on('posts.displayed_post_id', '=', 'responded_count_table.dest_d_post_id');
            })->where('posts.thread_id', $request->value)->orderBy('posts.id');
        } else if ($request->where == 'user_id') {
            $query->where('posts.user_id', $request->value)->orderBy('posts.id', 'desc');
        } else if ($request->where == 'user_like') {
            $query->whereIn('posts.id', function ($query) use ($request) {
                $query->select('post_id')->from('likes')->where('user_id', $request->value);
            })->orderBy('posts.id', 'desc');
        }

        $posts = $query->get();
        return $posts;
    }

    //ポスト削除
    public function destroy(Request $request)
    {
        Post::where('user_id', Auth::id())->where('id', $request->id)->delete();

        $image_controller = new ImageController();
        $image_controller->destroy($request->id);
        //threadsテーブルのlike_countデクリメント
        // $thread = new Thread();
        // $thread->find($request->thread_id)->decrement('post_count');
    }
}
