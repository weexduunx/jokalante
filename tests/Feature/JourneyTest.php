<?php

namespace Tests\Feature;

use App\Livewire\Journey;
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
            ->assertSet('screen', 'diagnostic')
            ->call('answer', 'zone', 'pikine')
            ->call('answer', 'connectivite', 'partage')
            ->call('answer', 'interet', 'reparation')
            ->call('answer', 'temps', 'weekend')
            ->assertSet('screen', 'result')
            ->assertNotSet('competenceId', null);
    }

    public function test_trainer_page_loads(): void
    {
        $this->get('/formateur')->assertOk();
    }
}
