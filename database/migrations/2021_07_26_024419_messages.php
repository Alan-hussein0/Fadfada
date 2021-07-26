<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Messages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('messages');
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->unsigned();
            $table->uuid('chat_id');
            $table->longText('message');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->foreign('chat_id')
                    ->references('id')
                    ->on('chats')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
