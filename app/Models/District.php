<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class District extends Model
{
    use HasFactory;

    public function city() {
        return $this->belongsTo(City::class);
    }
}
