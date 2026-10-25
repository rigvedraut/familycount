<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class FamilyHead extends Model
{
    protected $fillable = [
        'name', 'surname', 'birthdate', 'mobile_no',
        'address', 'state_id', 'city_id', 'pincode',
        'marital_status', 'wedding_date', 'photo',
    ];

    protected $casts = [
        'birthdate' => 'date',
        'wedding_date' => 'date',
    ];

    protected $appends = ['photo_url'];

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(FamilyMember::class);
    }

    public function hobbies(): HasMany
    {
        return $this->hasMany(FamilyHobby::class);
    }

    public function getPhotoUrlAttribute(): ?string
    {
        if (! $this->photo) {
            return null;
        }

        return Storage::disk('public')->url($this->photo);
    }
}