<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Like extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'post_id'];

    //リレーション定義
    public function user()
    {
        return $this->belongsTo((User::class));
    }
    public function post()
    {
        return $this->belongsTo((Post::class));
    }
}
