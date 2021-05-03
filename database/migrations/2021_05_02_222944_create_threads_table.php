<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('threads', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes();
            $table->unsignedBigInteger('user_id')->comment('スレッド作成ユーザーID')->default(null);
            $table->string('title', 100)->comment('スレッドタイトル');
            $table->unsignedSmallInteger('image_id')->comment('スレッド画像ID')->default(0);
            $table->boolean('is_edited')->default(false)->comment('編集済みか')->default(0);
            $table->unsignedSmallInteger('post_count')->comment('総書込数')->default(0);
            $table->unsignedSmallInteger('like_count')->comment('総わかる数')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('threads');
    }
}
