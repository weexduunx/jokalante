<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('learners', function (Blueprint $table) {
            $table->id();
            $table->uuid('anonymous_id')->unique();
            $table->string('langue_preferee', 8)->default('fr');
            $table->string('zone_geo')->nullable();
            $table->string('tranche_age')->nullable();
            $table->string('niveau_etude')->nullable();
            $table->string('objectif')->nullable();
            $table->string('niveau_experience')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('learners');
    }
};
