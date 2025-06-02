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

    public function city() {
        return $this->belongsTo(City::class);
    }

    public function attributeValues() {
        return $this->hasMany(AttributeValue::class);
    }

    protected $appends = ['atmosphere_text'];

    public function schedules()
    {
        return $this->hasMany(Schedule::class)->orderBy('day_of_week');
    }

    public function todayWorkingHours()
    {
        $currentDayName = strtolower(date('l'));
    
        return $this->hasOne(Schedule::class)
        ->where('day_of_week', $currentDayName);
    }

    public function kitchens(): BelongsToMany
    {
        return $this->belongsToMany(Kitchen::class, 'place_kitchens');
    }

    public function images()
    {
        return $this->hasMany(PlaceImage::class)->orderBy('sort_order');
    }

    public const AVERAGE_CHECK_RANGES = [
        1 => [
            'min' => 0,
            'max' => 649,
            'text' => 'до 650',
        ],
        2 => [
            'min' => 650,
            'max' => 1599,
            'text' => '650-1600',
        ],
        3 => [
            'min' => 1600,
            'max' => 2799,
            'text' => '1600-2800',
        ],
        4 => [
            'min' => 2800,
            'max' => PHP_INT_MAX, // Без верхней границы
            'text' => 'от 2800',
        ],
    ];

    public static function getAverageCheckRange(int $averageCheck): array
    {
        foreach (self::AVERAGE_CHECK_RANGES as $rangeNumber => $range) {
            if ($averageCheck >= $range['min'] && $averageCheck <= $range['max']) {
                return [
                    'text' => $range['text'],
                    'range_number' => $rangeNumber,
                ];
            }
        }

        // На случай, если не попали ни в один диапазон (не должно происходить)
        return [
            'text' => 'не определен',
            'range_number' => 0,
        ];
    }

    /**
     * Получить все доступные диапазоны
     * 
     * @return array
     */
    public static function getAvailableRanges(): array
    {
        return self::AVERAGE_CHECK_RANGES;
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
    ];

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')
            ->withTimestamps();
    }

    public function setPhoneFormattedAttribute($value)
    {
        $this->attributes['phone_formatted'] = $value;
        $this->attributes['phone_numeric'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function activeAdvertisingTopListCampaigns()
    {
        return $this->hasMany(AdvertisingCampaign::class)
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>=', now())
            ->where('type_id', 1);
    }

    public function getAtmosphereTextAttribute(): string
    {
       $value = $this->atmosphere; // Это массив из-за casts
    
        // Если atmosphere хранит массив с одним элементом (например, ['quiet'])
        if (is_array($value)) {
            // Берем первый элемент массива
            $key = reset($value);
            return self::ATMOSPHERE_ANSWERS[$key] ?? $key;
        }
        
        // Если вдруг atmosphere не массив (хотя casts настроен)
        return self::ATMOSPHERE_ANSWERS[$value] ?? $value;
    }


}
