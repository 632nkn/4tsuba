<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNgWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ng_words', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            //外部キー付き
            $table->foreignId('user_id')->nullable()->comment('ユーザーID')->default(5)
                ->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('ng_word', 10)->comment('NGワード');
            //複合uniqueキー
            $table->unique(['user_id', 'ng_word']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ng_words');
    }
}
