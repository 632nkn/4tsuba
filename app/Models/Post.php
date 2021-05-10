<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'thread_id', 'displayed_post_id',
        'body', 'has_image'
    ];

    //リレーション定義
    public function user()
    {
        return $this->belongsTo((User::class));
    }

    public function thread()
    {
        return $this->belongsTo((Thread::class));
    }

    public function image()
    {
        return $this->hasOne(Image::class);
    }
}
