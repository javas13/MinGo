<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ['place_id', 'day_of_week', 'open_time', 'close_time', 'is_closed'];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
    
    public function getDayNameAttribute()
    {
        return trans('days.' . $this->day_of_week);
    }

    protected static function russianToEnglishDays(): array
    {
        return [
            'понедельник' => 'monday',
            'вторник'     => 'tuesday',
            'среда'       => 'wednesday',
            'четверг'     => 'thursday',
            'пятница'     => 'friday',
            'суббота'     => 'saturday',
            'воскресенье' => 'sunday'
        ];
    }

    public function getOpenTimeFormattedAttribute()
    {
        return $this->open_time ? date('H:i', strtotime($this->open_time)) : null;
    }

    public function getCloseTimeFormattedAttribute()
    {
        return $this->close_time ? date('H:i', strtotime($this->close_time)) : null;
    }
}
