<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('substitutions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('zapas_id');
            $table->unsignedBigInteger('home_player_id');
            $table->unsignedBigInteger('away_player_id');
            $table->integer('minute');
            $table->timestamps();
            $table->foreign('zapas_id')->references('id')->on('zapas')->onDelete('cascade');
            $table->foreign('home_player_id')->references('id')->on('players')->onDelete('cascade');
            $table->foreign('away_player_id')->references('id')->on('players')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('substitutions');
    }

};
