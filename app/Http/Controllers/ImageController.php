<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;


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
}
