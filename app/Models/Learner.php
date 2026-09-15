<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Learner extends Model
{
    protected $fillable = [
        'anonymous_id',
        'langue_preferee',
        'zone_geo',
        'tranche_age',
        'niveau_etude',
        'objectif',
        'niveau_experience',
    ];

    protected static function booted(): void
    {
        static::creating(function (Learner $learner): void {
            $learner->anonymous_id ??= (string) Str::uuid();
        });
    }

    public function diagnostics(): HasMany
    {
        return $this->hasMany(Diagnostic::class);
    }

    public function progressRecords(): HasMany
    {
        return $this->hasMany(ProgressRecord::class);
    }

    public function savedOpportunities(): HasMany
    {
        return $this->hasMany(SavedOpportunity::class);
    }
}
