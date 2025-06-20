<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertisingCampaign extends Model
{
    use HasFactory;

    public function place() {
        return $this->belongsTo(Place::class);
    }

    public function type() {
        return $this->belongsTo(AdvertisingTypes::class);
    }
}
