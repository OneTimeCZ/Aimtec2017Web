<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_objects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->integer('type')->unsigned();
            $table->integer('pos_x')->unsigned();
            $table->integer('pos_y')->unsigned();
            $table->integer('time')->unsigned();
            $table->integer('game_id')->unsigned();
            $table->timestamps();

            $table->foreign('game_id')->references('id')->on('games');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('game_objects');
    }
}
