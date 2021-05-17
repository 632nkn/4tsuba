<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;



class UserController extends Controller
{
    public function returnUserInfo($user_id)
    {
        return User::where('id', $user_id)
            ->withCount(['posts' => function ($query) {
                $query->withTrashed();
            }, 'likes'])->get()[0];
    }

    public function editName(Request $request)
    {
        User::find(Auth::id())->update(['name' => $request->name]);
    }
}
