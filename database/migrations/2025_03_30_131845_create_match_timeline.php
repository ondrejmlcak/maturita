<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('match_timeline', function (Blueprint $table) {
            $table->id();
            $table->foreignId('match_id')->constrained('zapas')->onDelete('cascade');
            $table->foreignId('team_id')->constrained('teams')->onDelete('cascade');
            $table->string('event_type');
            $table->integer('minute');
            $table->string('player_name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('match_timeline');
    }
};
