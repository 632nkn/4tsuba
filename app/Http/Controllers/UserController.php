<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;



class UserController extends Controller
{
    public function returnUserInfo(Request $request)
    {
        $user_id_list = $request->user_id_list;
        return User::whereIn('id', $user_id_list)
            ->withCount([
                'posts' => function ($query) {
                    $query->withTrashed();
                },
                'likes',
                'mute_users AS is_login_user_mute' => function ($query) use ($user_id_list) {
                    $query->where('muting_user_id', Auth::id())->where('user_id', $user_id_list[0]);
                },
            ])->get();
    }




    public function editProfile(Request $request)
    {
        User::find(Auth::id())->update(['name' => $request->name,]);

        if ($request->file('icon')) {
            $uploaded_icon = $request->file('icon');
            $uploaded_icon->store('public/icons');
            User::find(Auth::id())->update([
                'icon_name' => $uploaded_icon->hashName(),
                'icon_size' => $uploaded_icon->getSize(),
            ]);
        }
    }
}
