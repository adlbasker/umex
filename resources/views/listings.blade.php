@extends('layout')

@section('meta_title', $page->meta_title ?? $page->title)

@section('meta_description', $page->meta_description ?? $page->title)

@section('head')

@endsection

@section('content')

<div id="titlebar" class="margin-bottom-50">
  <div class="container">
    <div class="row">
      <div class="col-md-12">

        <h1>{{ $page->title }}</h1>

        <!-- Breadcrumbs -->
        <nav id="breadcrumbs">
          <ul>
            <li><a href="/{{ $lang }}">{{ __('Main') }}</a></li>
            @if ($page->ancestors->count())
              <li><a href="/{{ $lang }}/i/{{ $page->parent->slug }}">{{ $page->parent->title }}</a></li>
            @endif
            <li>{{ $page->title }}</li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</div>

<?php
$type = $_GET['type'] ?? 0;
$typeOfPropertyId = $_GET['type_of_property'] ?? 0;
$roomsId = $_GET['rooms'] ?? 0;

?>

<!-- Search -->
<section class="container filter-catalog">
  <div class="row">
    <div class="col-lg-offset-2 col-lg-8">
      <form method="GET" action="/{{ $lang }}/i/catalog/parameters">
        <div class="main-search-box">
          <!-- <h3 class="text-center text-uppercase">{{ __('Find Home') }}</h3> -->
          <div class="row with-forms">
            <!-- Type -->
            <div class="col-md-4 col-sm-6 col-xs-6">
              <select name="type" data-placeholder="Any Type" class="chosen-select-no-single">
                <option value="0">{{ __('Rent & Sale') }}</option>
                <option value="2" @if($type == 2) selected @endif>{{ __('For Rent') }}</option>
                <option value="1" @if($type == 1) selected @endif>{{ __('For Sale') }}</option>
              </select>
            </div>

            <!-- Property Type -->
            <div class="col-md-3 col-sm-6 col-xs-6">
              <select name="type_of_property" data-placeholder="Any Type of Property" class="chosen-select-no-single" >
                <option value="0">{{ __('Property Type') }}</option>
                @foreach($options as $option)
                  <?php $data = json_decode($option->data, true); ?>
                  @if (in_array($data[$lang]['data'], ['Тип обьекта', 'Type of property']))
                    <?php $titles = json_decode($option->title, true); ?>
                    <option value="{{ $option->id }}" @if($typeOfPropertyId == $option->id) selected @endif>{{ $titles[$lang]['title'] }}</option>
                  @endif
                @endforeach
              </select>
            </div>

            <!-- Rooms -->
            <div class="col-md-3 col-sm-6 col-xs-6">
              <select name="rooms" data-placeholder="Any Rooms" class="chosen-select-no-single" >
                <option value="0">{{ __('Any Rooms') }}</option>
                @foreach($options as $option)
                  <?php $data = json_decode($option->data, true); ?>
                  @if (in_array($data[$lang]['data'], ['Количество комнат', 'Number of rooms', 'Комнаты', 'Rooms']))
                    <?php $titles = json_decode($option->title, true); ?>
                    <option value="{{ $option->id }}" @if($roomsId == $option->id) selected @endif>{{ $titles[$lang]['title'] }}</option>
                  @endif
                @endforeach
              </select>
            </div>

            <!-- Rooms -->
            <div class="col-md-2 col-sm-6 col-xs-6">
              <button type="submit" class="button">{{ __('Search') }}</button>
            </div>
          </div>
          @if(!empty($_GET))
            <div class="text-center">
              <a href="/{{ $lang }}/i/catalog">{{ __('Reset') }}</a>
            </div>
          @endif
        </div>
      </form>
    </div>
  </div>
</section>

<div class="clearfix"></div>

<!-- Content -->
<div class="container margin-bottom-50">
  <div class="row fullwidth-layout">

    <div class="col-md-12">

      <!-- Listings -->
      <div class="listings-container grid-layout-three">

        <?php $i = 1; ?>
        @foreach($products as $product)

          <?php
            $productLang = $product->productsLang->where('lang', $lang)->first();
            if ($productLang == false) {
              continue;
            }
          ?>
          <div class="listing-item">
            <a href="/{{ $lang }}/p/{{ $productLang->slug }}" class="listing-img-container">
              <div class="listing-badges">
                <span>{{ __('statuses.condition.'.$product->condition) }}</span>
              </div>
              <div class="listing-img-content">
                <span class="listing-price">{{ number_format($product->price_total, 0, ' ', ' ') }}₸</span>
              </div>
              <img src="/img/products/{{ $product->path.'/'.$product->image }}" alt="{{ $product->title }}">
            </a>

            <div class="listing-content">
              <div class="listing-title">
                <h4><a href="/{{ $lang }}/p/{{ $productLang->slug }}">{{ $product->title }}</a></h4>
                <a href="#" class="listing-address popup-gmaps">
                  <i class="fa fa-map-marker"></i>
                  @if ($productLang->category_id != 0) {{ $productLang->category->title }}, @endif
                  {{ $productLang->characteristic }}
                </a>
              </div>
              <ul class="listing-features">
                @foreach ($product->options as $option)
                  <?php $data = json_decode($option->data, true); ?>
                  @if (in_array($data[$lang]['data'], ['Тип обьекта', 'Type of property', 'Количество комнат', 'Number of rooms', 'Комнаты', 'Rooms']))
                    <?php $titles = json_decode($option->title, true); ?>
                    <li>{{ $data[$lang]['data'] }} <span>{{ $titles[$lang]['title'] }}</span></li>
                  @endif
                @endforeach
              </ul>
              <!-- <div class="listing-footer">
                <a href="#"><i class="fa fa-bank"></i> {{ $product->company->title }}</a>
              </div> -->
            </div>
          </div>
          <?php if ($i++ == 3) : $i = 1; ?>
            <div class="clearfix"></div>
          <?php endif; ?>
        @endforeach
      </div>

      <div class="clearfix"></div>
      <div class="pagination-container margin-top-20">
        {{ $products->links('vendor.pagination.bootstrap-custom') }}
      </div>

    </div>

  </div>
</div>

@endsection

@section('scripts')
  <script>
    // Actions
    $('#actions').change(function() {

      var action = $(this).val();
      var page = $(location).attr('href').split('catalog')[1];
      var slug = page.split('?')[0];

      $.ajax({
        type: "get",
        url: '/{{ $lang }}/catalog'.page,
        dataType: "json",
        data: {
          "action": action
        },
        success: function(data) {
          $('#products').html(data);
          // location.reload();
        }
      });
    });
  </script>
@endsection