<div class="">
    <div class="place-card @if($place->activeAdvertisingTopListCampaigns->isNotEmpty()) place-card-promoted @endif">
        @if($place->activeAdvertisingTopListCampaigns->isNotEmpty()) <div class="place-card__promo-badge">Рекоммендуем</div> @endif
        <a target="_blank" class="place-image-box" href="{{ route('places.elem', $place->slug) }}" >
            <img src="@if($place->thumb_image_src == null) /img/admin/no-image.png @else {{ $place->thumb_image_src }} @endif" class="place-image" alt="Ресторан">
            @auth
                {{-- Пользователь авторизован --}}
                <button class="favorite-btn {{ auth()->user()->favoritePlaces->contains($place->id) ? 'active' : '' }} favorite-btn-js" data-place-id="{{ $place->id }}">
                    <i class="fa-heart {{ auth()->user()->favoritePlaces->contains($place->id) ? 'fas' : 'far' }}"></i>
                </button>
            @else
                {{-- Пользователь не авторизован --}}
                <button class="favorite-btn favorite-btn-js" data-place-id="{{ $place->id }}">
                    <i class="far fa-heart"></i>
                </button>
            @endauth
        </a>
        <div class="place-body">
            <h3 class="place-title">{{ $place->name }}</h5>
            <div class="place-price">
                <div class="@if($place->category->name == 'Картинги') place-card__category-col @else place-card__category-row @endif">
                    <div class="place-card__category">{{ $place->category->name_single }}</div>
                    @if($place->category->name == 'Картинги')
                    <div>Цена заезда: от {{ $place->check_in_price_from }}₽ до {{ $place->check_in_price_to }}₽</div>
                    @elseif($place->average_bill != null)
                    <div class="place-card__categ-separator">-</div>
                    <div class="place-card__average-bill-row" data-bs-trigger="hover" data-bs-toggle="popover" title="График работы" data-bs-placement="top" data-bs-template='<div class="popover average-bill-popover" role="tooltip"><div class="popover-arrow"></div><div class="popover-body d-flex flex-column"></div></div>' data-bs-html="true" data-bs-content="@include('partials.average-bill-popup')">
                        @foreach(App\Models\Place::getAvailableRanges() as $rangeNumber => $range)
                        <span class="place-card__average-bill-ruble @if(App\Models\Place::getAverageCheckRange($place->average_bill)['range_number'] >=  $rangeNumber) active @endif">₽</span>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            <div class="place-card__atmosphere">
                @if($place->atmosphere_text == 'Тихое место')
                <i class="fas fa-volume-mute"></i> {{ $place->atmosphere_text; }}
                @else
                <i class="fas fa-volume-up"></i> {{ $place->atmosphere_text; }}
                @endif
            </div>
            <p class="place-address">
                <i class="fas fa-map-marker-alt"></i>
                {{ $place->address }}
            </p>
        </div>
    </div>
</div>