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
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->softDeletes();
            //外部キー付き
            $table->foreignId('user_id')->nullable()->comment('ユーザーID')->default(5)
                ->constrained()->onDelete('set null')->onUpdate('cascade');
            //外部キー付き
            $table->foreignId('thread_id')->comment('スレッドID')->default(1)
                ->constrained()->onDelete('restrict')->onUpdate('restrict');
            $table->unsignedBigInteger('displayed_post_id')->comment('スレッド内ポストID')->default(1);
            $table->string('body', 1000)->comment('本文')->default('本文なし');
            $table->boolean('has_image')->comment('画像があるか')->default(false);
            $table->boolean('is_edited')->comment('編集済みか')->storedAs('case when created_at = updated_at then 0 else 1 end');

            //複合uniqueキー(ソフトデリートするので、deleted_atを含む必要がある)
            $table->unique(['thread_id', 'displayed_post_id', 'deleted_at']);
            //外部キー古い書き方
            //$table->foreign('thread_id')->references('id')->on('threads')->onDelete('cascade')->onUpdate('cascade');
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
