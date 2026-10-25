<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class FamilyMember extends Model
{
    protected $fillable = [
        'name', 'birthdate', 'marital_status',
        'wedding_date', 'education', 'photo',
    ];

    protected $casts = [
        'birthdate' => 'date',
        'wedding_date' => 'date',
    ];

    protected $appends = ['photo_url'];

    public function familyHead(): BelongsTo
    {
        return $this->belongsTo(FamilyHead::class);
    }

    public function getPhotoUrlAttribute(): ?string
    {
        if (! $this->photo) {
            return null;
        }

        return Storage::disk('public')->url($this->photo);
    }
}