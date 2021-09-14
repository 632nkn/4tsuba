<?php

namespace App\Http\Controllers;

use App\Models\MuteWord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class MuteWordController extends Controller
{
    public function index()
    {
        return MuteWord::where('user_id', Auth::id())->orderBy('id', 'desc')->get();
    }

    public function store(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'mute_word' => 'required|unique:mute_words|max:255',
        // ]);

        // if ($validator->fails()) {
        //     $errors = $validator->errors();
        //     return $errors;
        // }

        //既に登録済みか否かをチェック
        $is_already_stored = MuteWord::where('user_id', Auth::id())->where('mute_word', $request->mute_word)->count();
        if (!$is_already_stored) {
            MuteWord::create([
                'user_id' => Auth::id(),
                'mute_word' => $request->mute_word,
            ]);
        } else {
            return "is_already_stored";
        }
    }

    public function destroy(Request $request)
    {
        MuteWord::where('user_id', Auth::id())->where('id', $request->id)->delete();
    }
}
