<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Like;

use Illuminate\Support\Facades\DB;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        //リクエストされたファイルの情報を持ったUploadedFileクラスのインスタンス
        $uploaded_image = $request->file('image');
        //ファイル保存処理  storage/app/public/images の意味 app配下から記述する
        $uploaded_image->store('public/images');

        $image = Image::create([
            'thread_id' => $request->thread_id,
            'post_id' => $request->post_id,
            'image_name' => $uploaded_image->hashName(),
            'image_size' => $uploaded_image->getSize(),
        ]);
    }

    public function edit(Request $request)
    {
        $uploaded_image = $request->file('image');
        $uploaded_image->store('public/images');

        Image::where('post_id', $request->id)
            ->updateOrCreate(
                [
                    'post_id' => $request->id
                ],
                [
                    'thread_id' => $request->thread_id,
                    'image_name' => $uploaded_image->hashName(),
                    'image_size' => $uploaded_image->getSize(),
                ]
            );
    }

    public function destroy($post_id)
    {
        Image::where('post_id', $post_id)->delete();
    }

    public function returnImagesForTheThread($thread_id)
    {
        $images = DB::table('images')->leftJoin('posts', 'images.post_id', '=', 'posts.id')
            ->leftJoin('users', 'posts.user_id', '=', 'users.id')->select(
                'posts.displayed_post_id',
                'images.post_id',
                DB::raw('CONCAT("/storage/images/", images.image_name) as thumb'),
                DB::raw('CONCAT("/storage/images/", images.image_name) as src'),
                DB::raw('CONCAT("【レス番:", posts.displayed_post_id, "】【ユーザー:", users.name, "】「", posts.body, "」") as caption'),
            )->where('images.thread_id', $thread_id)->orderBy('posts.displayed_post_id')->get();
        return $images;
    }

    public function returnImagesTheUserPosted($user_id)
    {
        $images = DB::table('images')->leftJoin('posts', 'images.post_id', '=', 'posts.id')
            ->leftJoin('threads', 'images.thread_id', '=', 'threads.id')
            ->select(
                'posts.displayed_post_id',
                'images.post_id',
                DB::raw('CONCAT("/storage/images/", images.image_name) as thumb'),
                DB::raw('CONCAT("/storage/images/", images.image_name) as src'),
                DB::raw('CONCAT("【スレッド:", threads.title, "】【レス番:", posts.displayed_post_id, "】「", posts.body, "」") as caption'),
            )->where('posts.user_id', $user_id)->orderBy('posts.id', 'desc')->get();
        return $images;
    }
    public function returnImagesTheUserLiked($user_id)
    {

        $images = DB::table('images')->leftJoin('posts', 'images.post_id', '=', 'posts.id')
            ->leftJoin('threads', 'images.thread_id', '=', 'threads.id')
            ->select(
                'posts.displayed_post_id',
                'images.post_id',
                DB::raw('CONCAT("/storage/images/", images.image_name) as thumb'),
                DB::raw('CONCAT("/storage/images/", images.image_name) as src'),
                DB::raw('CONCAT("【スレッド:", threads.title, "】【レス番:", posts.displayed_post_id, "】「", posts.body, "」") as caption'),
            )->whereIn('images.post_id', function ($query) use ($user_id) {
                $query->select('post_id')->from('likes')->where('likes.user_id', $user_id);
            })->orderBy('posts.id', 'desc')->get();
        return $images;
    }
}
