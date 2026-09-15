<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoadmapStep extends Model
{
    protected $fillable = [
        'competence_id',
        'titre_fr',
        'titre_wo',
        'description_fr',
        'description_wo',
        'position',
        'duree_minutes',
    ];

    public function competence(): BelongsTo
    {
        return $this->belongsTo(Competence::class);
    }

    public function progressRecords(): HasMany
    {
        return $this->hasMany(ProgressRecord::class);
    }

    public function titre(): string
    {
        return app()->getLocale() === 'wo' ? $this->titre_wo : $this->titre_fr;
    }

    public function description(): string
    {
        return app()->getLocale() === 'wo' ? $this->description_wo : $this->description_fr;
    }
}
