<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('competences', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('nom_fr');
            $table->string('nom_wo');
            $table->text('description_fr');
            $table->text('description_wo');
            $table->string('niveau');
            $table->string('zone_geo')->default('dakar-pikine');
            $table->unsignedSmallInteger('demande_locale')->default(0);
            $table->string('justification_source');
            $table->date('source_updated_on');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('competences');
    }
};
