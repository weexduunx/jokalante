<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgressRecord extends Model
{
    protected $fillable = ['learner_id', 'roadmap_step_id', 'statut', 'completed_at'];

    protected function casts(): array
    {
        return ['completed_at' => 'datetime'];
    }

    public function learner(): BelongsTo
    {
        return $this->belongsTo(Learner::class);
    }

    public function roadmapStep(): BelongsTo
    {
        return $this->belongsTo(RoadmapStep::class);
    }
}
