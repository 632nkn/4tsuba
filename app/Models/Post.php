<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'thread_id', 'displayed_post_id',
        'body', 'has_image'
    ];
    //日付のキャスト
    protected $casts = [
        'created_at' => 'datetime:Y/n/j H:i',
        'updated_at' => 'datetime:Y/n/j H:i',
        'deleted_at' => 'datetime:Y/n/j H:i',
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
    public function likes()
    {
        return $this->hasMany(like::class);
    }

    //呼び出しメソッド
    public function returnMaxDisplayedPostId($thread_id)
    {
        return $this->where('thread_id', $thread_id)->withTrashed()->count();
    }

    public function returnLoginUserPostTable($thread_id)
    {
        return $this->select('id as login_user_posted_post_id', DB::raw('1 as is_login_user_posted'))
            ->where('thread_id', $thread_id)->where('user_id', Auth::id())
            ->whereNotNull('user_id');
    }
}
