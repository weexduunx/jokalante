<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Diagnostic extends Model
{
    protected $fillable = [
        'learner_id',
        'session_token',
        'reponses',
        'competence_recommandee_id',
    ];

    protected function casts(): array
    {
        return [
            'reponses' => 'array',
        ];
    }

    public function learner(): BelongsTo
    {
        return $this->belongsTo(Learner::class);
    }

    public function competence(): BelongsTo
    {
        return $this->belongsTo(Competence::class, 'competence_recommandee_id');
    }
}
