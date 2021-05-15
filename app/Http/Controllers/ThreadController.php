<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;
use App\Models\Image;
//authを使用する
use Illuminate\Support\Facades\Auth;


class ThreadController extends Controller
{
    //スレッド取得
    public function index(Request $request)
    {

        $image = new Image();
        $thread_image_table = $image->returnThreadImageTable();

        $sort_list = array("最終更新", "作成日時", "書込数", "いいね数");
        $order_set = array();

        switch ($request->sort) {
            case $sort_list[0]:
                array_push($order_set, 'updated_at');
                break;
            case $sort_list[1]:
                array_push($order_set, 'created_at');
                break;
            case $sort_list[2]:
                array_push($order_set, 'post_count');
                break;
            case $sort_list[3]:
                array_push($order_set, 'like_count');
                break;
            default:
                array_push($order_set, 'updated_at');
        }

        switch ($request->order) {
            case 'desc':
                array_push($order_set, 'desc');
                break;
            case 'asc':
                array_push($order_set, 'asc');
                break;
            default:
                array_push($order_set, 'desc');
        }

        return Thread::select('*')
            ->leftJoinSub($thread_image_table, 'thread_image_table', function ($join) {
                $join->on('threads.id', '=', 'thread_image_table.thread_id');
            })
            ->orderBy('threads.' . $order_set[0], $order_set[1])->get();
    }

    //★個別スレッド show
    public function show($thread_id)
    {
        $image = new Image();
        $thread_image_table = $image->returnThreadImageTable();

        return Thread
            ::leftJoinSub($thread_image_table, 'thread_image_table', function ($join) {
                $join->on('threads.id', '=', 'thread_image_table.thread_id');
            })
            ->find($thread_id);
    }

    //スレッド store
    public function store(Request $request)
    {
        $thread = Thread::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
        ]);

        //リクエストにスレッドidを追加
        $request->merge([
            'thread_id' => $thread->id,
        ]);

        $post_controller = new PostController();
        $post_controller->store($request);
    }
}
