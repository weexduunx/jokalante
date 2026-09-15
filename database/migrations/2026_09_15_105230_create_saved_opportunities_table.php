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
        Schema::create('saved_opportunities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learner_id')->constrained()->cascadeOnDelete();
            $table->foreignId('opportunite_id')->constrained('opportunites')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['learner_id', 'opportunite_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saved_opportunities');
    }
};
