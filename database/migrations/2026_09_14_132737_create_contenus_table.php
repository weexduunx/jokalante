<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contenus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('competence_id')->constrained()->cascadeOnDelete();
            $table->string('type')->default('texte');
            $table->text('corps_fr');
            $table->text('corps_wo');
            $table->text('script_audio_fr');
            $table->text('script_audio_wo');
            $table->string('source');
            $table->boolean('signale_obsolete')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contenus');
    }
};
