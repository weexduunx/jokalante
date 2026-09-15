<?php

namespace Tests\Feature;

use App\Livewire\Journey;
use App\Models\Competence;
use App\Models\Report;
use App\Services\DiagnosticEngine;
use Database\Seeders\CatalogueSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;

class JourneyTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(CatalogueSeeder::class);
        config()->set('services.groq.api_key', null);
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

    public function test_diagnostic_keeps_going_after_the_zone_question(): void
    {
        Livewire::test(Journey::class)
            ->call('start')
            ->call('answer', 'age', '21-25')
            ->call('answer', 'niveauEtude', 'bac')
            ->call('answer', 'objectif', 'emploi')
            ->call('answer', 'zone', 'pikine')
            ->assertSet('screen', 'diagnostic')
            ->assertSet('question', 4);
    }

    public function test_groq_suggests_interest_options_after_region_selection(): void
    {
        config()->set('services.groq.api_key', 'test-groq-key');

        Http::fakeSequence()
            ->push([
                'choices' => [[
                    'message' => [
                        'content' => '{"catalogue":[{"slug":"maintenance-informatique","name":"Diagnostiquer un ordinateur","description":"Analyser et réparer un poste informatique.","reason":"Piste adaptée à l objectif et à la région."},{"slug":"agriculture","name":"Cultiver et transformer","description":"Produire et valoriser des ressources locales.","reason":"Piste liée aux possibilités du territoire."}]}',
                    ],
                ]],
            ])
            ->push([
                'choices' => [[
                    'message' => [
                        'content' => '{"competence_slug":"formation-apprentissage","opportunity_ids":[]}',
                    ],
                ]],
            ]);

        Livewire::test(Journey::class)
            ->call('start')
            ->call('answer', 'age', '21-25')
            ->call('answer', 'niveauEtude', 'bac')
            ->call('answer', 'objectif', 'emploi')
            ->call('answer', 'zone', 'saint-louis')
            ->assertSet('question', 4)
            ->assertSet('suggestedCatalogue.0.slug', 'reparation')
            ->call('answer', 'connectivite', 'smartphone')
            ->call('answer', 'interet', 'reparation')
            ->call('answer', 'temps', 'plein-temps')
            ->call('answer', 'experience', 'debutant')
            ->assertSet('screen', 'result')
            ->assertSet('suggestedCatalogue.0.slug', 'maintenance-informatique')
            ->assertSet('suggestedCatalogue.0.description', 'Analyser et réparer un poste informatique.')
            ->assertSet('suggestedCatalogue.1.slug', 'agriculture');

        Http::assertSent(function (Request $request): bool {
            $messages = $request->data()['messages'] ?? [];

            return str_contains($messages[1]['content'] ?? '', 'maintenance-informatique');
        });
    }

    public function test_diagnostic_uses_groq_recommendation_when_configured(): void
    {
        config()->set('services.groq.api_key', 'test-groq-key');
        $opportunityId = Competence::query()->where('slug', 'formation-apprentissage')->firstOrFail()->opportunites()->valueOrFail('id');

        Http::fake([
            'https://api.groq.com/*' => Http::response([
                'choices' => [[
                    'message' => [
                        'content' => json_encode([
                            'competence_slug' => 'formation-apprentissage',
                            'opportunity_ids' => [$opportunityId],
                            'profile_summary' => 'Profil orienté vers une formation technique.',
                            'strengths' => ['Curiosité technique'],
                            'skills_to_develop' => ['Installation solaire'],
                            'compatible_roles' => ['Technicien solaire'],
                            'reason' => 'La recommandation correspond au profil et à la zone.',
                            'next_action' => 'Consulter la session pratique vérifiée.',
                            'local_structures' => [[
                                'name' => 'ANPEJ',
                                'sector' => 'Orientation et emploi',
                                'region' => 'Dakar',
                                'url' => 'https://anpej.sn/accueil/services-aux-demandeurs/',
                                'evidence' => 'Service officiel d’accompagnement.',
                            ]],
                            'web_sources' => [[
                                'title' => 'Programme solaire officiel',
                                'url' => 'https://example.org/programme-solaire',
                                'publisher' => 'Organisme officiel',
                                'published_at' => '2026-09-10',
                                'reason' => 'Programme adapté au niveau et à la zone.',
                            ], [
                                'title' => 'Lien non sécurisé',
                                'url' => 'http://example.org/non-securise',
                                'publisher' => 'Source inconnue',
                                'published_at' => null,
                                'reason' => 'Ne doit pas apparaître.',
                            ]],
                        ], JSON_THROW_ON_ERROR),
                    ],
                ]],
            ]),
        ]);

        Livewire::test(Journey::class)
            ->call('start')
            ->call('answer', 'age', '21-25')
            ->call('answer', 'niveauEtude', 'bac')
            ->call('answer', 'objectif', 'emploi')
            ->call('answer', 'zone', 'dakar')
            ->call('answer', 'connectivite', 'smartphone')
            ->call('answer', 'interet', 'bureau')
            ->call('answer', 'temps', 'soirs')
            ->call('answer', 'experience', 'debutant')
            ->assertSet('competenceId', fn (int $id): bool => $id === $this->competenceId('formation-apprentissage'))
            ->assertSet('opportuniteId', $opportunityId)
            ->assertSet('aiAnalysis.reason', 'La recommandation correspond au profil et à la zone.')
            ->assertSet('aiAnalysis.local_structures.0.name', 'ANPEJ')
            ->assertSet('aiAnalysis.web_sources.0.url', 'https://example.org/programme-solaire')
            ->assertCount('aiAnalysis.web_sources', 1);

        Http::assertSent(function (Request $request): bool {
            $messages = $request->data()['messages'] ?? [];

            return $request->hasHeader('Authorization', 'Bearer test-groq-key')
                && str_contains($messages[1]['content'] ?? '', 'emploi')
                && str_contains($messages[1]['content'] ?? '', 'formation-apprentissage')
                && str_contains($messages[1]['content'] ?? '', 'opportunites_verifiees')
                && ($request->data()['compound_custom']['tools']['enabled_tools'] ?? []) === ['web_search'];
        });
    }

    public function test_fallback_recommendation_uses_the_objective(): void
    {
        config()->set('services.groq.api_key', null);

        $commonProfile = [
            'age' => '21-25',
            'niveau_etude' => 'bac',
            'zone' => 'dakar',
            'connectivite' => 'smartphone',
            'interet' => 'commerce',
            'temps' => 'soirs',
            'experience' => 'debutant',
        ];

        $emploi = app(DiagnosticEngine::class)->recommend([
            ...$commonProfile,
            'objectif' => 'emploi',
        ]);
        $activite = app(DiagnosticEngine::class)->recommend([
            ...$commonProfile,
            'objectif' => 'activite',
        ]);

        $this->assertNotSame($emploi->slug, $activite->slug);
        $this->assertSame('recherche-emploi', $emploi->slug);
        $this->assertSame('entrepreneuriat', $activite->slug);
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

    private function competenceId(string $slug): int
    {
        return Competence::query()->where('slug', $slug)->valueOrFail('id');
    }
}
