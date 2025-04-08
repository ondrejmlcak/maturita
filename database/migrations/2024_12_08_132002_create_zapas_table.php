<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('zapas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('home_team_id');
            $table->unsignedBigInteger('away_team_id');
            $table->integer('home_score')->default(0);
            $table->integer('away_score')->default(0);
            $table->enum('status', ['before', '1st', 'half_time', '2nd', 'full_time', 'after_90', '1st_extra', 'after_105', '2nd_extra', 'penalty', 'suspended'])->default('before');
            $table->string('stadium')->nullable();
            $table->integer('fans_count')->default(0);
            $table->string('referee')->nullable();
            $table->longText('home_lineup')->nullable();
            $table->longText('away_lineup')->nullable();
            $table->longText('home_substitutes')->nullable();
            $table->longText('away_substitutes')->nullable();
            $table->unsignedBigInteger('league_id')->nullable();
            $table->unsignedBigInteger('commentator_id')->nullable();
            $table->timestamp('match_date')->nullable();
            $table->integer('round_number')->nullable();
            $table->timestamps();

            $table->foreign('home_team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('away_team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('league_id')->references('id')->on('leagues')->onDelete('set null');
            $table->foreign('commentator_id')->references('id')->on('users')->onDelete('set null');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('zapas');
    }
};

