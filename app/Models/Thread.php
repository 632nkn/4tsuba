<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//ソフトデリートを有効にするために追加
use Illuminate\Database\Eloquent\SoftDeletes;


class Thread extends Model
{
    use HasFactory;
    //ソフトデリートを有効にするために追加
    use SoftDeletes;

    protected $fillable = ['user_id', 'title', 'post_count', 'like_count'];

    //日付のキャスト Threadモデルを使うとき、下記を整形する
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

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    //呼び出しメソッド
    public function incrementLikeCount($id)
    {
        $this->find($id)->increment('like_count');
    }

    public function decrementLikeCount($id)
    {
        $this->find($id)->decrement('like_count');
    }
}
