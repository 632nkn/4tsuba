<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//Laravel８式書き方
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ResponseController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test/{thread_id}', [PostController::class, 'returnPostCount']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);


//タスク
Route::get('/tasks', [TaskController::class, 'index']);
Route::get('/tasks/{task}', [TaskController::class, 'show']);
Route::post('/tasks', [TaskController::class, 'store']);
Route::put('/tasks/{task}', [TaskController::class, 'update']);
Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);

//thread
//クエリパラメータはルーティングに書かずとも$requestで取得できる
//例.  /threads?sort=2?desc=1  は $request->sort $request->desc

Route::group(['middleware' => ['auth:sanctum']], function () {
    //users
});
//開発のため一旦外だし
//threads
Route::get('/threads', [ThreadController::class, 'index']);
Route::get('/threads/{thread_id}', [ThreadController::class, 'show']);
Route::post('/threads', [ThreadController::class, 'store']);
//posts
Route::get('/posts/thread/{thread_id}', [PostController::class, 'index']);
Route::post('/posts', [PostController::class, 'store']);

//like
Route::put('/like', [LikeController::class, 'store']);
Route::delete('/like', [LikeController::class, 'destroy']);
