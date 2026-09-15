<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $legacySlugs = [
            'reparation-smartphone',
            'vente-whatsapp',
            'installation-solaire',
            'bureautique',
            'maintenance-pc',
            'electricite-batiment',
        ];
        $competenceIds = DB::table('competences')->whereIn('slug', $legacySlugs)->pluck('id');
        $opportunityIds = DB::table('opportunites')->whereIn('competence_id', $competenceIds)->pluck('id');
        $roadmapStepIds = DB::table('roadmap_steps')->whereIn('competence_id', $competenceIds)->pluck('id');

        DB::table('reports')->whereIn('opportunite_id', $opportunityIds)->delete();
        DB::table('saved_opportunities')->whereIn('opportunite_id', $opportunityIds)->delete();
        DB::table('progress_records')->whereIn('roadmap_step_id', $roadmapStepIds)->delete();
        DB::table('diagnostics')->whereIn('competence_recommandee_id', $competenceIds)->update([
            'competence_recommandee_id' => DB::table('competences')->where('slug', 'orientation-emploi')->value('id'),
            'opportunite_recommandee_id' => null,
        ]);
        DB::table('roadmap_steps')->whereIn('id', $roadmapStepIds)->delete();
        DB::table('contenus')->whereIn('competence_id', $competenceIds)->delete();
        DB::table('opportunites')->whereIn('id', $opportunityIds)->delete();
        DB::table('competences')->whereIn('id', $competenceIds)->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Les anciennes données étaient fictives et ne sont pas restaurées.
    }
};
