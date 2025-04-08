<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('match_id')->unsigned()->unique();
            $table->string('home_team');
            $table->string('away_team');
            $table->string('score')->nullable();
            $table->string('status')->nullable();
            $table->string('league')->nullable();
            $table->integer('minutes')->nullable();
            $table->timestamp('start_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
