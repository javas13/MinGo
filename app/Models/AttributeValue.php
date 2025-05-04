<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;

    public function place() {
        return $this->belongsTo(Place::class);
    }

    public function attribute() {
        return $this->belongsTo(CategoryAttribute::class, 'category_attribute_id');
    }
}
