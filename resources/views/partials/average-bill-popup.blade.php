<div>
    <div class='average-bill-popup__currency-row'>
        @for ($i = 0; $i < App\Models\Place::getAverageCheckRange($place->average_bill)['range_number']; $i++)
            <span>₽</span>
        @endfor
        <div>=</div>
        <div>{{ App\Models\Place::getAverageCheckRange($place->average_bill)['text'] }}</div>
    </div>
    <div>Ср. чек - {{ $place->average_bill }}</div>
</div>