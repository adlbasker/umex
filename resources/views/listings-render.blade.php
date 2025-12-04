  <div class="listings-container grid-layout-three">
    @foreach($productsLang as $productLang)
      <div class="listing-item">
        <a href="/{{ $lang }}/p/{{ $productLang->slug }}" class="listing-img-container">
          <div class="listing-badges">
            <span>{{ trans('statuses.condition.'.$productLang->product->condition) }}</span>
          </div>
          <div class="listing-img-content">
            <span class="listing-price">{{ number_format($productLang->price_total, 0, ' ', ' ') }}₸</span>
            <span class="like-icon with-tip" data-tip-content="Add to Bookmarks"></span>
          </div>
          <img src="/img/products/{{ $productLang->product->path.'/'.$productLang->product->image }}" alt="{{ $productLang->title }}">
        </a>

        <div class="listing-content">
          <div class="listing-title">
            <h4><a href="/{{ $lang }}/p/{{ $productLang->slug }}">{{ $productLang->title }}</a></h4>
            <a href="#" class="listing-address popup-gmaps">
              <i class="fa fa-map-marker"></i> {{ $productLang->characteristic }}
            </a>
          </div>
          <ul class="listing-features">
            @foreach ($productLang->product->options as $option)
              <?php $data = json_decode($option->data, true); ?>
              @if (in_array($data[$lang]['data'], ['Тип обьекта', 'Type of property', 'Количество комнат', 'Number of rooms', 'Комнаты', 'Rooms']))
                <?php $titles = json_decode($option->title, true); ?>
                <li>{{ $data[$lang]['data'] }} <span>{{ $titles[$lang]['title'] }}</span></li>
              @endif
            @endforeach
          </ul>
        </div>
      </div>
    @endforeach
  </div>

  <div class="clearfix"></div>
  <div class="pagination-container margin-top-20">
    {{ $productsLang->links() }}
  </div>