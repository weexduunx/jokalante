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
        Schema::create('roadmap_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('competence_id')->constrained()->cascadeOnDelete();
            $table->string('titre_fr');
            $table->string('titre_wo');
            $table->text('description_fr');
            $table->text('description_wo');
            $table->unsignedSmallInteger('position');
            $table->unsignedSmallInteger('duree_minutes')->default(15);
            $table->timestamps();

            $table->unique(['competence_id', 'position']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roadmap_steps');
    }
};
