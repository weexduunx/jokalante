<?php

namespace App\Livewire;

use App\Models\Learner;
use App\Models\Opportunite;
use App\Models\ProgressRecord;
use App\Models\RoadmapStep;
use App\Models\SavedOpportunity;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    public function toggleStep(int $stepId): void
    {
        $learner = $this->learner();
        $diagnostic = $learner?->diagnostics()->latest()->first();

        if (! $learner || ! $diagnostic) {
            return;
        }

        $step = RoadmapStep::query()
            ->where('id', $stepId)
            ->where('competence_id', $diagnostic->competence_recommandee_id)
            ->firstOrFail();
        $record = ProgressRecord::query()->firstOrNew([
            'learner_id' => $learner->id,
            'roadmap_step_id' => $step->id,
        ]);

        $record->statut = $record->statut === 'termine' ? 'a_faire' : 'termine';
        $record->completed_at = $record->statut === 'termine' ? now() : null;
        $record->save();
    }

    public function toggleSavedOpportunity(int $opportunityId): void
    {
        $learner = $this->learner();

        if (! $learner || ! Opportunite::query()->whereKey($opportunityId)->exists()) {
            return;
        }

        $saved = SavedOpportunity::query()
            ->where('learner_id', $learner->id)
            ->where('opportunite_id', $opportunityId)
            ->first();

        if ($saved) {
            $saved->delete();

            return;
        }

        SavedOpportunity::query()->create([
            'learner_id' => $learner->id,
            'opportunite_id' => $opportunityId,
        ]);
    }

    public function render()
    {
        $learner = $this->learner();
        $diagnostic = $learner?->diagnostics()->with(['competence', 'opportunite'])->latest()->first();
        $competence = $diagnostic?->competence;
        $steps = $competence?->roadmapSteps()->get() ?? new Collection;
        $progress = $learner
            ? $learner->progressRecords()->whereIn('roadmap_step_id', $steps->modelKeys())->get()->keyBy('roadmap_step_id')
            : new Collection;
        $savedOpportunities = $learner
            ? $learner->savedOpportunities()->with('opportunite.competence')->latest()->get()
            : new Collection;
        $completedSteps = $progress->where('statut', 'termine')->count();
        $progressPercent = $steps->count() > 0 ? (int) round(($completedSteps / $steps->count()) * 100) : 0;

        return view('livewire.dashboard', [
            'learner' => $learner,
            'diagnostic' => $diagnostic,
            'competence' => $competence,
            'steps' => $steps,
            'progress' => $progress,
            'savedOpportunities' => $savedOpportunities,
            'completedSteps' => $completedSteps,
            'progressPercent' => $progressPercent,
            'opportunity' => $diagnostic?->opportunite ?? $competence?->opportunites()->first(),
        ]);
    }

    private function learner(): ?Learner
    {
        $learnerId = session('learner_id');

        return $learnerId ? Learner::query()->find($learnerId) : null;
    }
}
