<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Competence extends Model
{
    protected $fillable = [
        'slug',
        'nom_fr',
        'nom_wo',
        'description_fr',
        'description_wo',
        'niveau',
        'zone_geo',
        'demande_locale',
        'justification_source',
        'source_updated_on',
    ];

    protected function casts(): array
    {
        return [
            'source_updated_on' => 'date',
        ];
    }

    public function nom(): string
    {
        return app()->getLocale() === 'wo' ? $this->nom_wo : $this->nom_fr;
    }

    public function description(): string
    {
        return app()->getLocale() === 'wo' ? $this->description_wo : $this->description_fr;
    }

    public function sourceIsStale(): bool
    {
        return $this->source_updated_on->lt(now()->subDays(90));
    }

    public function contenus(): HasMany
    {
        return $this->hasMany(Contenu::class);
    }

    public function opportunites(): HasMany
    {
        return $this->hasMany(Opportunite::class);
    }

    public function contenuPrincipal(): HasOne
    {
        return $this->hasOne(Contenu::class)->latestOfMany();
    }

    public function roadmapSteps(): HasMany
    {
        return $this->hasMany(RoadmapStep::class)->orderBy('position');
    }
}
