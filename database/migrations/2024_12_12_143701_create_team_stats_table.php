<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('zapas_id')->constrained('zapas')->onDelete('cascade');
            $table->foreignId('team_id')->constrained('teams')->onDelete('cascade');
            $table->integer('ball_possession')->default(0);
            $table->integer('shots_on_target')->default(0);
            $table->integer('shots_off_target')->default(0);
            $table->integer('corners')->default(0);
            $table->integer('fouls')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_stats');
    }
};
