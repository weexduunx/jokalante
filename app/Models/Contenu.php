<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contenu extends Model
{
    protected $fillable = [
        'competence_id',
        'type',
        'corps_fr',
        'corps_wo',
        'script_audio_fr',
        'script_audio_wo',
        'source',
        'signale_obsolete',
    ];

    protected function casts(): array
    {
        return [
            'signale_obsolete' => 'boolean',
        ];
    }

    public function competence(): BelongsTo
    {
        return $this->belongsTo(Competence::class);
    }

    public function corps(): string
    {
        return app()->getLocale() === 'wo' ? $this->corps_wo : $this->corps_fr;
    }

    public function scriptAudio(): string
    {
        return app()->getLocale() === 'wo' ? $this->script_audio_wo : $this->script_audio_fr;
    }
}
