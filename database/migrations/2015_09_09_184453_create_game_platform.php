<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamePlatform extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn('platform');
        });

        Schema::create('game_platform', function (Blueprint $table) {
            $table->integer('platform_id');
            $table->integer('game_id');
        });

        Schema::create('platforms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('game_platform');

        Schema::drop('platforms');

        Schema::table('games', function (Blueprint $table) {
            $table->string('platform');
        });
    }
}
