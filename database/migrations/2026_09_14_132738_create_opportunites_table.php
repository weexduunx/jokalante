<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('opportunites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('competence_id')->constrained()->cascadeOnDelete();
            $table->string('titre_fr');
            $table->string('titre_wo');
            $table->string('lieu');
            $table->string('contact');
            $table->text('condition_eligibilite_fr');
            $table->text('condition_eligibilite_wo');
            $table->string('delai_fr');
            $table->string('delai_wo');
            $table->string('source');
            $table->string('source_url')->nullable();
            $table->date('source_updated_on');
            $table->string('statut', 20)->default('a_verifier');
            $table->string('zone_geo')->default('dakar-pikine');
            $table->boolean('ajoutee_par_formateur')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opportunites');
    }
};
