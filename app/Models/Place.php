<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Place extends Model
{
    use HasFactory;

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function attributeValues() {
        return $this->hasMany(AttributeValue::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class)->orderBy('day_of_week');
    }

    public function kitchens(): BelongsToMany
    {
        return $this->belongsToMany(Kitchen::class, 'place_kitchens');
    }

    public function images()
    {
        return $this->hasMany(PlaceImage::class)->orderBy('sort_order');
    }

    protected $casts = [
        'mood' => 'array',
        'company' => 'array',
        'activity' => 'array',
        'budget' => 'array',
        'atmosphere' => 'array',
    ];

    const MOOD_ANSWERS = [
        'sad' => 'Грустное',
        'normal' => 'Нормальное',
        'happy' => 'Весёлое',
    ];

    const COMPANY_ANSWERS = [
        'alone' => 'Один',
        'family' => 'Семья',
        'date' => 'Свидание',
        'friends' => 'Друзья',
    ];

    const ACTIVITY_ANSWERS = [
        'eat' => 'Поесть',
        'walk' => 'Погулять',
        'rest' => 'Отдохнуть',
    ];

    const BUDGET_ANSWERS = [
        '1000' => 'До 1000₽',
        '1500' => '1000-1500₽',
        '2000' => '1500-2000₽',
        '3000' => '2000-3000₽',
        '3000+' => 'от 3000₽',
    ];

    const ATMOSPHERE_ANSWERS = [
        'quiet' => 'Тихое место',
        'noisy' => 'Шумное место',
        'any' => 'Без разницы',
    ];
}
