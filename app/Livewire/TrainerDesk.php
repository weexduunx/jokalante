<?php

namespace App\Livewire;

use App\Models\Competence;
use App\Models\Contenu;
use App\Models\Opportunite;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class TrainerDesk extends Component
{
    public string $competence_id = '';

    public string $titre_fr = '';

    public string $titre_wo = '';

    public string $lieu = '';

    public string $contact = '';

    public string $condition_fr = '';

    public string $delai_fr = '';

    public string $source = '';

    public bool $saved = false;

    public function flag(int $contenuId): void
    {
        $contenu = Contenu::query()->findOrFail($contenuId);
        $contenu->update(['signale_obsolete' => ! $contenu->signale_obsolete]);
    }

    public function addOpportunity(): void
    {
        $this->validate([
            'competence_id' => 'required|exists:competences,id',
            'titre_fr' => 'required|string|max:180',
            'lieu' => 'required|string|max:180',
            'contact' => 'required|string|max:120',
            'condition_fr' => 'required|string|max:400',
            'delai_fr' => 'required|string|max:180',
            'source' => 'required|string|max:180',
        ]);

        Opportunite::query()->create([
            'competence_id' => $this->competence_id,
            'titre_fr' => $this->titre_fr,
            'titre_wo' => $this->titre_wo !== '' ? $this->titre_wo : $this->titre_fr,
            'lieu' => $this->lieu,
            'contact' => $this->contact,
            'condition_eligibilite_fr' => $this->condition_fr,
            'condition_eligibilite_wo' => $this->condition_fr,
            'delai_fr' => $this->delai_fr,
            'delai_wo' => $this->delai_fr,
            'source' => $this->source,
            'source_updated_on' => now()->toDateString(),
            'zone_geo' => 'pikine',
            'ajoutee_par_formateur' => true,
        ]);

        $this->reset(['competence_id', 'titre_fr', 'titre_wo', 'lieu', 'contact', 'condition_fr', 'delai_fr', 'source']);
        $this->saved = true;
    }

    public function render()
    {
        return view('livewire.trainer-desk', [
            'competences' => Competence::query()->with('contenus')->orderBy('nom_fr')->get(),
        ]);
    }
}
