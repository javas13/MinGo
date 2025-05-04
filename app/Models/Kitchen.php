<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Kitchen extends Model
{
    use HasFactory;

    public function places(): BelongsToMany
    {
        return $this->belongsToMany(Place::class, 'place_kitchens');
    }
}
