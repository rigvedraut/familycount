<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FamilyHobby extends Model
{
    protected $fillable = ['hobby'];

    public function familyHead(): BelongsTo
    {
        return $this->belongsTo(FamilyHead::class);
    }
}