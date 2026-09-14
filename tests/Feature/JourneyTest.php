<?php

namespace Tests\Feature;

use App\Livewire\Journey;
use App\Models\Report;
use Database\Seeders\CatalogueSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class JourneyTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(CatalogueSeeder::class);
    }

    public function test_home_page_loads(): void
    {
        $this->get('/')->assertOk()->assertSee('Jokalante');
    }

    public function test_diagnostic_recommends_a_competence(): void
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
            ->call('answer', 'experience', 'debutant')
            ->assertSet('screen', 'result')
            ->assertNotSet('competenceId', null);
    }

    public function test_profile_is_stored_and_opportunity_can_be_reported(): void
    {
        $journey = Livewire::test(Journey::class)
            ->call('start')
            ->call('answer', 'age', '21-25')
            ->call('answer', 'niveauEtude', 'bac')
            ->call('answer', 'objectif', 'emploi')
            ->call('answer', 'zone', 'pikine')
            ->call('answer', 'connectivite', 'partage')
            ->call('answer', 'interet', 'reparation')
            ->call('answer', 'temps', 'weekend')
            ->call('answer', 'experience', 'debutant')
            ->call('openContent')
            ->call('openNext')
            ->set('reportReason', 'expiree')
            ->call('reportOpportunity');

        $journey->assertSet('reportSent', true);
        $this->assertDatabaseHas('learners', [
            'tranche_age' => '21-25',
            'niveau_etude' => 'bac',
            'objectif' => 'emploi',
            'niveau_experience' => 'debutant',
        ]);
        $this->assertDatabaseHas('reports', ['motif' => 'expiree']);
        $this->assertInstanceOf(Report::class, Report::query()->first());
    }

    public function test_trainer_page_loads(): void
    {
        $this->get('/formateur')->assertOk();
    }
}
