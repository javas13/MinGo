
<div class='schedule-popup__container'>
    @foreach($days as $dayNumber => $dayName)
    <div class='schedule-popup__day-row'>
        <div>{{ $dayName }}</div>
        @if($place->schedules[$dayNumber]->is_closed == true)
        <div class='text-danger'>Закрыто</div>
        @else
        <div>{{ $place->schedules[$dayNumber]->open_time_formatted }}-{{ $place->schedules[$dayNumber]->close_time_formatted }}</div>
        @endif
    </div>
    @endforeach
</div>
