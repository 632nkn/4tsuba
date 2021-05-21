<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;



class Image extends Model
{
    use HasFactory;
    protected $fillable = ['thread_id', 'post_id', 'image_name', 'image_size'];

    //リレーション定義
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    //呼び出しメソッド
    public function returnThreadImageTable()
    {
        return $this->select(
            'id as image_id',
            'thread_id',
            'image_name',
            'image_size'
        )->whereIn('post_id', function ($query) {
            $query->select(DB::raw('min(post_id)'))->from('images')->groupBy('thread_id');
        })->orderBy('thread_id', 'asc');
    }
}
