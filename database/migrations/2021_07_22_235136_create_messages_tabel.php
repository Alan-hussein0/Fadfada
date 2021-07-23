<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages_tabel', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('from_user_id')->unsigned();
            $table->bigInteger('to_user_id')->unsigned();
            $table->longText('text');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages_tabel');
    }
}
