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
}
