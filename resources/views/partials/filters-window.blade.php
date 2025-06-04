<div data-window-id="filters-window" class="filters-window__wrapper window-js">
  <div class="filters-window">
    <div data-for-window-id="filters-window" class="filters-window__close-btn filters-window__close-btn-js">
      <img src="/img/close2.svg">
    </div>
    <div class="filters-window__title">Фильтры</div>
    <div class="filters-window__content">
      <form method="GET" action="{{ route('temporary.results', $key) }}">
        <div class="accordion filters-accordion" id="accordionExample">
				<div class="accordion-item filter-accordion-item">
					<h2 class="accordion-header">
					<button class="accordion-button filter-accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
						Кухни
					</button>
					</h2>
					<div id="collapseOne" class="accordion-collapse collapse" style="">
					<div class="accordion-body filter-accordion-body gap-1">
						@foreach($kitchens as $elem)
						<label class="d-flex gap-2 align-items-center">
							<input name="kitchens[]" value="{{ $elem->id }}" @if(is_array(Request::get('kitchens')) && in_array($elem->id, Request::get('kitchens'))) checked @endif class="green-checkbox" type="checkbox">
							<span>{{ $elem->name }}</span>
						</label>
						@endforeach
					</div>
					</div>
				</div>
				<div class="accordion-item filter-accordion-item">
					<h2 class="accordion-header">
					<button class="accordion-button filter-accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
						Округа
					</button>
					</h2>
					<div id="collapseTwo" class="accordion-collapse collapse">
					<div class="accordion-body filter-accordion-body gap-1">
						@foreach($districts as $elem)
						<label class="d-flex gap-2 align-items-center">
							<input name="districts[]" value="{{ $elem->id }}" class="green-checkbox" @if(is_array(Request::get('districts')) && in_array($elem->id, Request::get('districts'))) checked @endif type="checkbox">
							<span>{{ $elem->name }}</span>
						</label>
						@endforeach
					</div>
					</div>
				</div>
				<div class="accordion-item filter-accordion-item">
					<h2 class="accordion-header">
						<button class="accordion-button filter-accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
						Бюджет
						</button>
					</h2>
					<div id="collapseThree" class="accordion-collapse collapse show">
						<div class="accordion-body filter-accordion-body gap-2">
							<div class="row">
								<div class="">
									<div class="mb-2">Выберите диапазон среднего чека</div>
									
									<div class="price-inputs">
										<div class="price-input">
											<label for="minPrice" class="form-label">От</label>
											<input type="number" class="form-control" id="minPrice" name="budjet-min" placeholder="100" value="{{ Request::get('budjet-min') ?? '' }}" min="100" max="20000">
										</div>
										<div class="price-input">
											<label for="maxPrice" class="form-label">До</label>
											<input type="number" class="form-control" id="maxPrice" placeholder="100000" value="{{ Request::get('budjet-max') ?? '' }}" name="budjet-max" min="100" max="20000">
										</div>
									</div>
									
									<div class="slider-container">
										<div id="priceSlider"></div>
									</div>
								</div>
						</div>
						</div>
					</div>
					</div>
			</div>
			<button type="submit" class="btn btn-primary mt-3">Применить</button>
      </form>
    </div>
  </div>
</div>