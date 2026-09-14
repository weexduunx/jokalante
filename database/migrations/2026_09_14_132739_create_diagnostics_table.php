<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diagnostics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learner_id')->nullable()->constrained()->nullOnDelete();
            $table->string('session_token', 64)->index();
            $table->json('reponses');
            $table->foreignId('competence_recommandee_id')->constrained('competences');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diagnostics');
    }
};
