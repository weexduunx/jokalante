<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('learners', function (Blueprint $table): void {
            if (! Schema::hasColumn('learners', 'tranche_age')) {
                $table->string('tranche_age')->nullable();
            }

            if (! Schema::hasColumn('learners', 'niveau_etude')) {
                $table->string('niveau_etude')->nullable();
            }

            if (! Schema::hasColumn('learners', 'objectif')) {
                $table->string('objectif')->nullable();
            }

            if (! Schema::hasColumn('learners', 'niveau_experience')) {
                $table->string('niveau_experience')->nullable();
            }
        });

        Schema::table('opportunites', function (Blueprint $table): void {
            if (! Schema::hasColumn('opportunites', 'source_url')) {
                $table->string('source_url')->nullable();
            }

            if (! Schema::hasColumn('opportunites', 'statut')) {
                $table->string('statut', 20)->default('a_verifier');
            }
        });
    }

    public function down(): void
    {
        Schema::table('learners', function (Blueprint $table): void {
            $columns = array_filter([
                Schema::hasColumn('learners', 'tranche_age') ? 'tranche_age' : null,
                Schema::hasColumn('learners', 'niveau_etude') ? 'niveau_etude' : null,
                Schema::hasColumn('learners', 'objectif') ? 'objectif' : null,
                Schema::hasColumn('learners', 'niveau_experience') ? 'niveau_experience' : null,
            ]);

            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });

        Schema::table('opportunites', function (Blueprint $table): void {
            $columns = array_filter([
                Schema::hasColumn('opportunites', 'source_url') ? 'source_url' : null,
                Schema::hasColumn('opportunites', 'statut') ? 'statut' : null,
            ]);

            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
