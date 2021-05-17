<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


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

    public function returnLoginUserLikeTable($thread_id)
    {
        return $this->select('id as login_user_liked_post_id', DB::raw('1 as is_login_user_liked'))
            ->where('user_id', Auth::id())->whereNotNull('user_id');
    }
}
