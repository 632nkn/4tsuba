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

    //日付のキャスト Threadモデルを使うとき、下記を整形する
    protected $casts = [
        'created_at' => 'datetime:Y/n/j H:i',
        'updated_at' => 'datetime:Y/n/j H:i',
        'deleted_at' => 'datetime:Y/n/j H:i',
    ];
}
