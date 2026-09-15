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
        'opportunite_recommandee_id',
        'analyse_ia',
    ];

    protected function casts(): array
    {
        return [
            'reponses' => 'array',
            'analyse_ia' => 'array',
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

    public function opportunite(): BelongsTo
    {
        return $this->belongsTo(Opportunite::class, 'opportunite_recommandee_id');
    }
}
