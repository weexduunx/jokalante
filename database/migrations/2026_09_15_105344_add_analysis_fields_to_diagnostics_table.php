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
        Schema::table('diagnostics', function (Blueprint $table) {
            $table->foreignId('opportunite_recommandee_id')->nullable()->after('competence_recommandee_id')->constrained('opportunites')->nullOnDelete();
            $table->json('analyse_ia')->nullable()->after('opportunite_recommandee_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diagnostics', function (Blueprint $table) {
            $table->dropForeign(['opportunite_recommandee_id']);
            $table->dropColumn(['opportunite_recommandee_id', 'analyse_ia']);
        });
    }
};
