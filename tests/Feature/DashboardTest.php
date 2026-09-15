<?php

namespace Tests\Feature;

use App\Livewire\Dashboard;
use App\Livewire\Journey;
use App\Models\Diagnostic;
use App\Models\ProgressRecord;
use App\Models\RoadmapStep;
use App\Models\SavedOpportunity;
use Database\Seeders\CatalogueSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(CatalogueSeeder::class);
        config()->set('services.groq.api_key', null);
    }

    public function test_dashboard_explains_how_to_start_without_a_diagnostic(): void
    {
        $this->get('/mon-parcours')
            ->assertOk()
            ->assertSeeText('Ton tableau de bord commence avec ton diagnostic.');
    }

    public function test_learner_can_track_a_step_and_save_an_opportunity(): void
    {
        Livewire::test(Journey::class)
            ->call('start')
            ->call('answer', 'age', '21-25')
            ->call('answer', 'niveauEtude', 'bac')
            ->call('answer', 'objectif', 'emploi')
            ->call('answer', 'zone', 'pikine')
            ->call('answer', 'connectivite', 'partage')
            ->call('answer', 'interet', 'reparation')
            ->call('answer', 'temps', 'weekend')
            ->call('answer', 'experience', 'debutant');

        $diagnostic = Diagnostic::query()->latest()->firstOrFail();
        $step = RoadmapStep::query()->where('competence_id', $diagnostic->competence_recommandee_id)->firstOrFail();
        $opportunityId = $diagnostic->opportunite_recommandee_id;

        Livewire::test(Dashboard::class)
            ->assertSee('Roadmap personnalisée')
            ->call('toggleStep', $step->id)
            ->call('toggleSavedOpportunity', $opportunityId)
            ->assertSee('opportunité');

        $this->assertDatabaseHas('progress_records', [
            'learner_id' => $diagnostic->learner_id,
            'roadmap_step_id' => $step->id,
            'statut' => 'termine',
        ]);
        $this->assertDatabaseHas('saved_opportunities', [
            'learner_id' => $diagnostic->learner_id,
            'opportunite_id' => $opportunityId,
        ]);
        $this->assertSame(1, ProgressRecord::query()->count());
        $this->assertSame(1, SavedOpportunity::query()->count());
    }
}
