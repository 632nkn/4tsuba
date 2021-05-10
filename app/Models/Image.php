<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
