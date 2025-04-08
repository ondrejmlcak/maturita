<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('zapas_id')->constrained('zapas')->onDelete('cascade')->notNull();
            $table->enum('event_type', ['goal', 'yellow_card', 'red_card', 'substitution', 'normal', 'important'])->nullable()->index();
            $table->integer('minute')->nullable()->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
