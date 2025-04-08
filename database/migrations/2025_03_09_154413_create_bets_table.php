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
        if (!Schema::hasTable('tickets') || !Schema::hasTable('matches')) {
            throw new Exception('Tabulky tickets a matches musí být vytvořeny před tabulkou bets.');
        }

        Schema::create('bets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_id');
            $table->unsignedBigInteger('match_id');
            $table->string('bet_type');
            $table->decimal('odd', 5, 2);
            $table->timestamps();

            $table->foreign('ticket_id')
                ->references('id')->on('tickets')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('match_id')
                ->references('match_id')
                ->on('matches')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bets');
    }
};
