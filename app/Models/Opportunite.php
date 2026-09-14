<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Opportunite extends Model
{
    protected $fillable = [
        'competence_id',
        'titre_fr',
        'titre_wo',
        'lieu',
        'contact',
        'condition_eligibilite_fr',
        'condition_eligibilite_wo',
        'delai_fr',
        'delai_wo',
        'source',
        'source_updated_on',
        'zone_geo',
        'ajoutee_par_formateur',
    ];

    protected function casts(): array
    {
        return [
            'source_updated_on' => 'date',
            'ajoutee_par_formateur' => 'boolean',
        ];
    }

    public function competence(): BelongsTo
    {
        return $this->belongsTo(Competence::class);
    }

    public function titre(): string
    {
        return app()->getLocale() === 'wo' ? $this->titre_wo : $this->titre_fr;
    }

    public function conditionEligibilite(): string
    {
        return app()->getLocale() === 'wo' ? $this->condition_eligibilite_wo : $this->condition_eligibilite_fr;
    }

    public function delai(): string
    {
        return app()->getLocale() === 'wo' ? $this->delai_wo : $this->delai_fr;
    }

    public function sourceIsStale(): bool
    {
        return $this->source_updated_on->lt(now()->subDays(90));
    }
}
