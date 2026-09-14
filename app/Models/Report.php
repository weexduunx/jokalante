<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    protected $fillable = ['opportunite_id', 'motif', 'description', 'statut'];

    public function opportunite(): BelongsTo
    {
        return $this->belongsTo(Opportunite::class);
    }
}
