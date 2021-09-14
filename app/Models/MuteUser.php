<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MuteUser extends Model
{
    protected $table = 'mute_users';
    use HasFactory;

    protected $fillable = [
        'muting_user_id', 'user_id'
    ];

    //リレーション定義
    public function user()
    {
        return $this->belongsTo((User::class));
    }
}
