<?php

namespace App\Livewire;

use App\Models\Competence;
use App\Models\Diagnostic;
use App\Models\Learner;
use App\Models\Report;
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

    public ?int $competenceId = null;

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
    }

    public function answer(string $field, string $value): void
    {
        $this->{$field} = $value;

        if ($this->question < 3) {
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

        $opportunite = $competence?->opportunites->first();

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
            $this->zone = $this->zone ?: 'pikine';
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
        $this->reset(['zone', 'age', 'niveauEtude', 'objectif', 'experience', 'connectivite', 'interet', 'temps', 'competenceId', 'question', 'reportReason', 'reportSent']);
        $this->screen = 'welcome';
        $this->showSms = false;
    }

    public function render()
    {
        $competence = $this->competenceId
            ? Competence::query()->with(['contenus', 'opportunites'])->find($this->competenceId)
            : null;

        return view('livewire.journey', [
            'competence' => $competence,
            'contenu' => $competence?->contenus->first(),
            'opportunite' => $competence?->opportunites->first(),
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
                'options' => [
                    'dakar' => __('q.zone.dakar'),
                    'pikine' => __('q.zone.pikine'),
                    'rufisque' => __('q.zone.rufisque'),
                    'thies-rural' => __('q.zone.thies-rural'),
                ],
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
                'options' => [
                    'reparation' => __('q.interet.reparation'),
                    'commerce' => __('q.interet.commerce'),
                    'energie' => __('q.interet.energie'),
                    'bureau' => __('q.interet.bureau'),
                ],
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

    private function finishDiagnostic(): void
    {
        $competence = app(DiagnosticEngine::class)->recommend([
            'zone' => $this->zone,
            'age' => $this->age,
            'niveau_etude' => $this->niveauEtude,
            'objectif' => $this->objectif,
            'experience' => $this->experience,
            'connectivite' => $this->connectivite,
            'interet' => $this->interet,
            'temps' => $this->temps,
        ]);

        $this->competenceId = $competence->id;

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
            'competence_recommandee_id' => $competence->id,
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
