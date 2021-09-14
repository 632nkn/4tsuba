<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//Laravel８式書き方
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MuteWordController;
use App\Http\Controllers\MuteUserController;


use App\Http\Controllers\AuthController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//検証
Route::get('/test', [MuteWordController::class, 'addHasMuteWordKeyToPosts']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);


//タスク
Route::get('/tasks', [TaskController::class, 'index']);
Route::get('/tasks/{task}', [TaskController::class, 'show']);
Route::post('/tasks', [TaskController::class, 'store']);
Route::put('/tasks/{task}', [TaskController::class, 'update']);
Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    //auth sanctum 通すURLはこの中入れる
});
//開発のため一旦外だし
// --------------------------------------------------------------------
//クエリパラメータはルーティングに書かずとも$requestで取得できる
//例.  /threads?sort=2?desc=1  は $request->sort $request->desc

//auth
Route::get('/users/me', [AuthController::class, 'returnMyId']);
Route::get('/users/me/info', [AuthController::class, 'returnMyInfo']);
Route::post('/users/me/confirm', [AuthController::class, 'checkPassword']);
Route::patch('users/', [AuthController::class, 'editPersonal']);

//users
Route::get('/users', [UserController::class, 'returnUserInfo']);
Route::post('/users/edit', [UserController::class, 'editProfile']);
//mute word
Route::get('/mute_words', [MuteWordController::class, 'index']);
Route::post('/mute_words', [MuteWordController::class, 'store']);
Route::delete('/mute_words', [MuteWordController::class, 'destroy']);
//mute user
Route::get('/mute_users', [MuteUserController::class, 'index']);
Route::put('/mute_users', [MuteUserController::class, 'store']);
Route::delete('/mute_users', [MuteUserController::class, 'destroy']);



//threads
Route::get('/threads', [ThreadController::class, 'index']);
Route::get('/threads/{thread_id}', [ThreadController::class, 'show']);
Route::post('/threads', [ThreadController::class, 'store']);
//posts
Route::get('/posts/', [PostController::class, 'index']);
Route::post('/posts', [PostController::class, 'store']);
Route::post('/posts/edit', [PostController::class, 'edit']);
Route::delete('/posts', [PostController::class, 'destroy']);
//images
Route::get('/images/threads', [ImageController::class, 'returnThreadImages']);

//like
Route::put('/like', [LikeController::class, 'store']);
Route::delete('/like', [LikeController::class, 'destroy']);
// --------------------------------------------------------------------
