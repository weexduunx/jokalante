<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SavedOpportunity extends Model
{
    protected $fillable = ['learner_id', 'opportunite_id'];

    public function learner(): BelongsTo
    {
        return $this->belongsTo(Learner::class);
    }

    public function opportunite(): BelongsTo
    {
        return $this->belongsTo(Opportunite::class);
    }
}
