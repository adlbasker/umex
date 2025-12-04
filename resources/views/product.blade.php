@extends('layout')

@section('meta_title', $productLang->meta_title ?? $productLang->title)

@section('meta_description', $productLang->meta_description ?? $productLang->title)

@section('head')
  @if ($productLang->product->images != '')
    <?php $images = unserialize($productLang->product->images); ?>
  @endif
  <meta property="og:title" content="{{ $productLang->title }}">
  <meta property="og:description" content="{{ strip_tags($productLang->description) }}">
  <meta property="og:image" content="https://umex.kz/img/products/{{ $productLang->product->path.'/'.$images[0]['image'] }}">
  <meta property="og:type" content="product">
@endsection

@section('content')

<!-- Titlebar -->
<div itemscope itemtype="http://schema.org/Product" id="titlebar" class="property-titlebar margin-bottom-0">
  <div class="container">
    <div class="row">
      <div class="col-md-12">

        <a href="{{ url()->previous() }}" class="back-to-listings"></a>

        <div class="property-title">
          <h1 itemprop="name">{{ $productLang->title }} <span class="property-badge">{{ trans('statuses.condition.'.$productLang->product->condition) }}</span></h1>
          <h2 itemprop="description">
            <span>
              <a href="#location" class="listing-address">
                <i class="fa fa-map-marker"></i>
                <?php $categoryTitle = ($productLang->category) ? $productLang->category->title : null; ?>
                {{ $productLang->characteristic }}
              </a>
            </span>
          </h2>
        </div>

        <div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="property-pricing">
          <div itemprop="price" class="property-price">{{ number_format($productLang->price_total, 0, ' ', ' ') }}₸</div>
          @if($productLang->price > 0)
            <div itemprop="price" class="sub-price">{{ number_format($productLang->price, 0, ' ', ' ') }}₸</div>
          @endif
        </div>
      </div>
    </div>
  </div>

  <!-- Content -->
  <div class="container">

    @include('partials.notifications')

    <div class="row margin-bottom-50">
      <div class="col-md-12">
      
        <!-- Slider -->
        <div class="property-slider default">
          @if ($productLang->product->images != '')
            <?php $images = unserialize($productLang->product->images); ?>
            @foreach ($images as $k => $image)
              <a itemprop="image" href="/img/products/{{ $productLang->product->path.'/'.$images[$k]['image'] }}" data-background-image="/img/products/{{ $productLang->product->path.'/'.$images[$k]['image'] }}" class="item mfp-gallery"></a>
            @endforeach
          @else
            <a itemprop="image" href="/images/single-property-02.jpg" data-background-image="images/single-property-02.jpg" class="item mfp-gallery"></a>
          @endif
        </div>

        <!-- Slider Thumbs -->
        <div class="property-slider-nav">
          @if ($productLang->product->images != '')
            @foreach ($images as $k => $image)
              <div class="item"><img src="/img/products/{{ $productLang->product->path.'/'.$images[$k]['present_image'] }}" alt="{{ $productLang->title }}"></div>
            @endforeach
          @endif
        </div>

      </div>
    </div>

    <div class="row margin-bottom-50">

      <!-- Property Description -->
      <div class="col-lg-8 col-md-7 sp-content">
        <div itemprop="description" class="property-description">

          <!-- Main Features -->
          <ul class="property-main-features">
            @foreach ($productLang->product->options as $option)
              <?php $data = json_decode($option->data, true); ?>
              @unless (in_array($data[$lang]['data'], ['Год постройки', 'Year of construction']))
                <?php $titles = json_decode($option->title, true); ?>
                <li>{{ $data[$lang]['data'] }} <div class="text-black">{{ $titles[$lang]['title'] }}</div></li>
              @endunless
            @endforeach
          </ul><br>

          <!-- Details -->
          <h3 class="desc-headline- margin-bottom-30">{{ __('Details') }}</h3>
          <table class="table table-striped">
            <tbody>
              <tr>
                <th scope="row">{{ __('Number of Object') }}: </th>
                <td><span>{{ $productLang->product->barcode }}</span></td>
              </tr>
              <tr>
                <th scope="row">{{ __('Region') }}: </th>
                <td><span>{{ $categoryTitle }}</span></td>
              </tr>
              @unless($productLang->product->company->slug == 'no-name')
              <tr>
                <th scope="row">{{ __('Company') }}:</th>
                <td> <span>{{ $productLang->product->company->title }}</span></td>
              </tr>
              @endunless
              @if(!empty($productLang->product->capacity))
                <tr>
                  <th scope="row">{{ __('Area Total') }}: </th>
                  <td><span>{{ $productLang->product->capacity }}</span></td>
                </tr>
              @endif
              @if(!empty($productLang->product->area))
                <tr>
                  <th scope="row">{{ __('Area') }}:</th>
                  <td><span>{{ $productLang->product->area }}</span></td>
                </tr>
              @endif
            </tbody>
          </table>

          <!-- Description -->
          @if ($productLang->description != NULL)
            <h3 class="desc-headline">{{ __('Description') }}</h3>
            {!! $productLang->description !!}
            <!-- <div class="show-more">
              <a href="#" class="show-more-button">{{ __('Show More') }} <i class="fa fa-angle-down"></i></a>
            </div> -->
          @endif

        </div>
      </div>


      <!-- Sidebar -->
      <div class="col-lg-4 col-md-5 sp-sidebar">
        <div class="sidebar sticky right">

          <!-- Widget -->
          <div class="widget">
            <div class="agent-widget">
              <form action="/{{ $lang }}/send-app" name="contact" method="post">
                @csrf
                <h3>{{ __('Booking form') }}</h3>
                <input type="name" name="name" id="name" placeholder="{{ __('Your Name') }}" required>
                <input type="surname" name="surname" id="surname" class="hidden" placeholder="{{ __('Your Surname') }}">
                <input type="tel" pattern="(\+?\d[- .]*){7,13}" name="phone" minlength="5" maxlength="20" placeholder="{{ __('Your Phone') }}" required>
                <textarea name="message" autocomplete="off" required>{{ __('Text form') }} {{ $product->barcode }}]</textarea>
                <button class="button fullwidth margin-top-5">{{ __('Send Message') }}</button>
              </form>
            </div>
          </div>

          <!-- Widget -->
          <!-- <div class="widget margin-bottom-30">
            <button class="widget-button with-tip" data-tip-content="Print"><i class="sl sl-icon-printer"></i></button>
            <button class="widget-button with-tip" data-tip-content="Add to Bookmarks"><i class="fa fa-star-o"></i></button>
            <div class="clearfix"></div>
          </div> -->

        </div>
      </div>

    </div>
  </div>
</div>

@endsection

@section('scripts')

@endsection