<?php

namespace App\Livewire;

use App\Models\Competence;
use App\Models\Diagnostic;
use App\Models\Learner;
use App\Models\Report;
use App\Services\AIServiceInterface;
use App\Services\DiagnosticEngine;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Journey extends Component
{
    public string $screen = 'welcome';

    public int $question = 0;

    public string $zone = '';

    public string $age = '';

    public string $niveauEtude = '';

    public string $objectif = '';

    public string $experience = '';

    public string $connectivite = '';

    public string $interet = '';

    public string $temps = '';

    /** @var list<array{slug:string,name:string,description:string,reason:string}> */
    public array $suggestedCatalogue = [];

    public ?int $competenceId = null;

    public ?int $opportuniteId = null;

    /** @var array{profile_summary?:string, strengths?:list<string>, skills_to_develop?:list<string>, compatible_roles?:list<string>, reason?:string, next_action?:string, local_structures?:list<array{name:string,sector:string,region:string,url:string,evidence:string}>, web_sources?:list<array{title:string,url:string,publisher:string,published_at:?string,reason:string}>} */
    public array $aiAnalysis = [];

    public bool $showSms = false;

    public string $reportReason = '';

    public bool $reportSent = false;

    public function mount(): void
    {
        $this->ensureLearner();

        if (request()->boolean('sms')) {
            $this->showSms = true;
            $this->screen = 'sms';
        }
    }

    public function start(): void
    {
        $this->screen = 'diagnostic';
        $this->question = 0;
        $this->showSms = false;
        $this->suggestedCatalogue = $this->fallbackCatalogue();
    }

    public function answer(string $field, string $value): void
    {
        $this->{$field} = $value;

        if ($field === 'zone') {
            // Keep the regional question immediate; Groq prepares the catalogue before the interest question.
            $this->suggestedCatalogue = $this->fallbackCatalogue();
        }

        if ($field === 'connectivite') {
            $this->suggestedCatalogue = $this->proposeCatalogue();
        }

        if ($this->question < count($this->questions()) - 1) {
            $this->question++;

            return;
        }

        $this->finishDiagnostic();
    }

    public function back(): void
    {
        if ($this->screen === 'diagnostic' && $this->question > 0) {
            $this->question--;

            return;
        }

        if ($this->screen === 'content') {
            $this->screen = 'result';

            return;
        }

        if ($this->screen === 'next') {
            $this->screen = 'content';

            return;
        }

        if (in_array($this->screen, ['result', 'sms', 'diagnostic'], true)) {
            $this->screen = 'welcome';
            $this->question = 0;
        }
    }

    public function openContent(): void
    {
        $this->screen = 'content';
    }

    public function openNext(): void
    {
        $this->screen = 'next';
    }

    public function reportOpportunity(): void
    {
        $this->validate(['reportReason' => 'required|string|max:80']);

        $competence = $this->competenceId
            ? Competence::query()->with('opportunites')->find($this->competenceId)
            : null;

        $opportunite = $competence?->opportunites->firstWhere('id', $this->opportuniteId)
            ?? $competence?->opportunites->first();

        if ($opportunite) {
            Report::query()->create([
                'opportunite_id' => $opportunite->id,
                'motif' => $this->reportReason,
            ]);
        }

        $this->reportSent = true;
    }

    public function openSms(): void
    {
        if (! $this->competenceId) {
            $this->age = $this->age ?: '21-25';
            $this->niveauEtude = $this->niveauEtude ?: 'bac';
            $this->objectif = $this->objectif ?: 'emploi';
            $this->experience = $this->experience ?: 'debutant';
            $this->zone = $this->zone ?: 'dakar';
            $this->connectivite = $this->connectivite ?: '2g';
            $this->interet = $this->interet ?: 'commerce';
            $this->temps = $this->temps ?: 'soirs';
            $this->finishDiagnostic();
        }

        $this->showSms = true;
        $this->screen = 'sms';
    }

    public function restart(): void
    {
        $this->reset(['zone', 'age', 'niveauEtude', 'objectif', 'experience', 'connectivite', 'interet', 'temps', 'suggestedCatalogue', 'competenceId', 'opportuniteId', 'aiAnalysis', 'question', 'reportReason', 'reportSent']);
        $this->screen = 'welcome';
        $this->showSms = false;
    }

    public function render()
    {
        $competence = $this->competenceId
            ? Competence::query()->with(['contenus', 'opportunites'])->find($this->competenceId)
            : null;
        $opportunite = $competence?->opportunites->firstWhere('id', $this->opportuniteId)
            ?? $competence?->opportunites->first();

        return view('livewire.journey', [
            'competence' => $competence,
            'contenu' => $competence?->contenus->first(),
            'opportunite' => $opportunite,
            'analysis' => $this->aiAnalysis,
            'questions' => $this->questions(),
        ]);
    }

    /**
     * @return list<array{field:string,label:string,options:array<string,string>}>
     */
    private function questions(): array
    {
        return [
            [
                'field' => 'age',
                'label' => __('q.age'),
                'options' => [
                    '16-20' => __('q.age.16-20'),
                    '21-25' => __('q.age.21-25'),
                    '26-35' => __('q.age.26-35'),
                    '36-plus' => __('q.age.36-plus'),
                ],
            ],
            [
                'field' => 'niveauEtude',
                'label' => __('q.education'),
                'options' => [
                    'sans-diplome' => __('q.education.sans-diplome'),
                    'bfem' => __('q.education.bfem'),
                    'bac' => __('q.education.bac'),
                    'superieur' => __('q.education.superieur'),
                ],
            ],
            [
                'field' => 'objectif',
                'label' => __('q.goal'),
                'options' => [
                    'emploi' => __('q.goal.emploi'),
                    'activite' => __('q.goal.activite'),
                    'formation' => __('q.goal.formation'),
                ],
            ],
            [
                'field' => 'zone',
                'label' => __('q.zone'),
                'options' => $this->regionOptions(),
            ],
            [
                'field' => 'connectivite',
                'label' => __('q.connectivite'),
                'options' => [
                    'smartphone' => __('q.connectivite.smartphone'),
                    'partage' => __('q.connectivite.partage'),
                    '2g' => __('q.connectivite.2g'),
                ],
            ],
            [
                'field' => 'interet',
                'label' => __('q.interet'),
                'options' => collect($this->suggestedCatalogue ?: $this->fallbackCatalogue())
                    ->mapWithKeys(fn (array $item): array => [$item['slug'] => $item['name']])
                    ->all(),
            ],
            [
                'field' => 'temps',
                'label' => __('q.temps'),
                'options' => [
                    'soirs' => __('q.temps.soirs'),
                    'weekend' => __('q.temps.weekend'),
                    'plein-temps' => __('q.temps.plein-temps'),
                ],
            ],
            [
                'field' => 'experience',
                'label' => __('q.experience'),
                'options' => [
                    'debutant' => __('q.experience.debutant'),
                    'quelques-bases' => __('q.experience.quelques-bases'),
                    'autonome' => __('q.experience.autonome'),
                ],
            ],
        ];
    }

    /** @return array<string, string> */
    private function regionOptions(): array
    {
        return [
            'dakar' => __('q.region.dakar'),
            'diourbel' => __('q.region.diourbel'),
            'fatick' => __('q.region.fatick'),
            'kaffrine' => __('q.region.kaffrine'),
            'kaolack' => __('q.region.kaolack'),
            'kedougou' => __('q.region.kedougou'),
            'kolda' => __('q.region.kolda'),
            'louga' => __('q.region.louga'),
            'matam' => __('q.region.matam'),
            'saint-louis' => __('q.region.saint-louis'),
            'sedhiou' => __('q.region.sedhiou'),
            'tambacounda' => __('q.region.tambacounda'),
            'thies' => __('q.region.thies'),
            'ziguinchor' => __('q.region.ziguinchor'),
        ];
    }

    /** @return list<array{slug:string,name:string,description:string,reason:string}> */
    private function fallbackCatalogue(): array
    {
        return [
            ['slug' => 'reparation', 'name' => __('q.interet.reparation'), 'description' => 'Diagnostiquer et remettre en état des équipements.', 'reason' => 'Piste pratique accessible aux débutants.'],
            ['slug' => 'commerce', 'name' => __('q.interet.commerce'), 'description' => 'Présenter une offre, vendre et accompagner un client.', 'reason' => 'Piste compatible avec une activité locale.'],
            ['slug' => 'energie', 'name' => __('q.interet.energie'), 'description' => 'Installer et entretenir des solutions énergétiques.', 'reason' => 'Piste utile dans plusieurs territoires.'],
            ['slug' => 'bureau', 'name' => __('q.interet.bureau'), 'description' => 'Organiser des dossiers et traiter des informations.', 'reason' => 'Piste transversale pour l’emploi.'],
        ];
    }

    /** @return list<array{slug:string,name:string,description:string,reason:string}> */
    private function proposeCatalogue(): array
    {
        $competences = Competence::query()->get()->map(fn (Competence $competence): array => [
            'slug' => $competence->slug,
            'name' => $competence->nom_fr,
            'description' => $competence->description_fr,
            'level' => $competence->niveau,
            'zone' => $competence->zone_geo,
        ])->all();

        $suggestions = app(AIServiceInterface::class)->proposeCatalogue([
            'age' => $this->age,
            'niveau_etude' => $this->niveauEtude,
            'objectif' => $this->objectif,
            'zone' => $this->zone,
        ], $competences);

        return $suggestions !== [] ? $suggestions : $this->fallbackCatalogue();
    }

    private function finishDiagnostic(): void
    {
        $this->suggestedCatalogue = $this->suggestedCatalogue ?: $this->proposeCatalogue();

        $result = app(DiagnosticEngine::class)->analyze([
            'zone' => $this->zone,
            'age' => $this->age,
            'niveau_etude' => $this->niveauEtude,
            'objectif' => $this->objectif,
            'experience' => $this->experience,
            'connectivite' => $this->connectivite,
            'interet' => $this->interet,
            'temps' => $this->temps,
        ], $this->suggestedCatalogue);

        $this->competenceId = $result['competence']->id;
        $this->opportuniteId = $result['opportunity_id'];
        $this->aiAnalysis = $result['analysis'];

        $learner = $this->ensureLearner();
        $learner->update([
            'zone_geo' => $this->zone,
            'tranche_age' => $this->age,
            'niveau_etude' => $this->niveauEtude,
            'objectif' => $this->objectif,
            'niveau_experience' => $this->experience,
        ]);

        Diagnostic::query()->create([
            'learner_id' => $learner->id,
            'session_token' => session()->getId(),
            'reponses' => [
                'zone' => $this->zone,
                'age' => $this->age,
                'niveau_etude' => $this->niveauEtude,
                'objectif' => $this->objectif,
                'experience' => $this->experience,
                'connectivite' => $this->connectivite,
                'interet' => $this->interet,
                'temps' => $this->temps,
            ],
            'competence_recommandee_id' => $result['competence']->id,
            'opportunite_recommandee_id' => $result['opportunity_id'],
            'analyse_ia' => $result['analysis'],
        ]);

        $this->screen = 'result';
    }

    private function ensureLearner(): Learner
    {
        $id = session('learner_id');

        if ($id) {
            $learner = Learner::query()->find($id);
            if ($learner) {
                return $learner;
            }
        }

        $learner = Learner::query()->create([
            'anonymous_id' => (string) Str::uuid(),
            'langue_preferee' => session('locale', 'fr'),
        ]);

        session(['learner_id' => $learner->id]);

        return $learner;
    }
}
