<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes();
            $table->unsignedBigInteger('user_id')->comment('ユーザーID')->default(1);
            $table->unsignedBigInteger('thread_id')->comment('スレッドID')->default(1);
            $table->unsignedBigInteger('displayed_post_id')->comment('スレッド表示上ポストID')->default(1);
            $table->string('body', 1000)->comment('書込本文')->default('本文なし');
            $table->boolean('has_image')->comment('画像があるか')->default(false);
            $table->boolean('is_edited')->comment('編集済みか')->default(false);

            // 論理削除されていれば NULL， されていなければ 1 になる生成列を定義
            $table->boolean('exist')->nullable()->storedAs('case when deleted_at is null then 1 else null end');
            //複合uniqueキー
            $table->unique(['thread_id', 'displayed_post_id', 'exist']);
            //外部キー
            $table->foreign('thread_id')->references('id')->on('threads')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
