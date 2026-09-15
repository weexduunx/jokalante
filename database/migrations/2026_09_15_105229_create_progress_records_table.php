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
        Schema::create('progress_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learner_id')->constrained()->cascadeOnDelete();
            $table->foreignId('roadmap_step_id')->constrained()->cascadeOnDelete();
            $table->string('statut', 20)->default('a_faire');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['learner_id', 'roadmap_step_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress_records');
    }
};
