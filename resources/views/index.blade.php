@extends('layout')

@section('meta_title', $page->meta_title ?? $page->title)

@section('meta_description', $page->meta_description ?? $page->title)

@section('head')
  <meta property="og:title" content="{{ $page->meta_title }}">
  <meta property="og:description" content="{{ $page->meta_description }}">
  <meta property="og:image" content="https://umex.kz/img/logo.png">
  <meta property="og:type" content="website">
@endsection

@section('content')

  @if($banners->count() >= 1)
    <!-- Slider -->
    <div class="fullwidth-home-slider margin-bottom-40">
      @foreach($banners as $key => $banner)
        <div data-background-image="/img/banners/{{ $banner->image }}" class="item">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <div class="home-slider-container">

                  <!-- Slide Title -->
                  <div class="home-slider-desc">
                    <div class="home-slider-price">{{ $banner->marketing }}</div>
                    <div class="home-slider-title">
                      @if($key == 0)
                        <h1><a class="text-white" href="/{{ $banner->link }}">{{ $banner->title }}</a></h1>
                      @else
                        <h2><a class="text-white" href="/{{ $banner->link }}">{{ $banner->title }}</a></h2>
                      @endif
                    </div>
                    <a href="/{{ $banner->link }}" class="button border-yellow btn-yellow read-more-">{{ __('Details') }} <i class="fa fa-angle-right"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @else
    <!-- Titlebar -->
    <div class="parallax titlebar margin-bottom-40"
      data-background="/img/bg-1-1500.jpg"
      data-color="#333333"
      data-color-opacity="0"
      data-img-width="800"
      data-img-height="505">

      <div id="titlebar">
        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <?php $tagline = $section->firstWhere('slug', 'tagline'); ?>
              {!! $tagline->content !!}
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif

  <!-- Search -->
  <section class="container filter-section">
    <div class="row">
      <div class="col-lg-offset-2 col-lg-8">
        <form method="GET" action="/{{ $lang }}/i/catalog/parameters">
          <div class="main-search-box">
            <h3 class="text-center text-uppercase">{{ __('Find Home') }}</h3>
            <div class="row with-forms">
              <!-- Type -->
              <div class="col-md-4 col-sm-6 col-xs-6">
                <select name="type" data-placeholder="Any Type" class="chosen-select-no-single">
                  <option value="0">{{ __('Rent & Sale') }}</option>
                  <option value="2">{{ __('For Rent') }}</option>
                  <option value="1">{{ __('For Sale') }}</option>
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
                      <option value="{{ $option->id }}">{{ $titles[$lang]['title'] }}</option>
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
                      <option value="{{ $option->id }}">{{ $titles[$lang]['title'] }}</option>
                    @endif
                  @endforeach
                </select>
              </div>

              <!-- Rooms -->
              <div class="col-md-2 col-sm-6 col-xs-6">
                <button type="submit" class="button">{{ __('Search') }}</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>

  <!-- Properties -->
  <section class="container padding-bottom-50">

    <div class="row">
      <div class="col-sm-8 col-md-8">
        <h2 class="h1 text-blue text-uppercase margin-bottom-35">{{ __('Offer') }}</h2>
      </div>

      <div class="col-sm-4 col-md-4 text-right">
        <a href="/{{ $lang }}/i/{{ $pages->firstWhere('slug', 'catalog')->slug }}" class="button">{{ $pages->firstWhere('slug', 'catalog')->title }}</a>
      </div>
    </div>

    <div class="row">
      <?php $i = 1; $modeTitles = unserialize($modeRecommended->title); ?>
      @foreach($modeRecommended->products->take(6) as $product)
        <?php $productLang = $product->productsLang->where('lang', $lang)->first(); ?>
        @if ($productLang != null)
          <div class="col-sm-6 col-md-4">
            <div itemscope itemtype="http://schema.org/Product" class="listing-item">
              <a href="/{{ $lang }}/p/{{ $productLang->slug }}" class="listing-img-container">
                <div itemprop="description" class="listing-badges">
                  <span class="featured">{{ $modeTitles[$lang]['title'] }}</span>
                  <span>{{ trans('statuses.condition.'.$product->condition) }}</span>
                </div>
                <div class="listing-img-content">
                  <span class="listing-price">{{ number_format($productLang->price_total, 0, ' ', ' ') }}₸</span>
                  <!-- <span class="like-icon with-tip" data-tip-content="Add to Bookmarks"></span> -->
                </div>
                <img src="/img/products/{{ $product->path.'/'.$product->image }}" alt="{{ $productLang->title }}">
              </a>

              <div class="listing-content">
                <div class="listing-title">
                  <h4 itemprop="name"><a href="/{{ $lang }}/p/{{ $productLang->slug }}">{{ $productLang->title }}</a></h4>
                  <a itemprop="description" href="#" class="listing-address popup-gmaps">
                    <i class="fa fa-map-marker"></i>
                    @if($productLang->category) {{ $productLang->category->title }}, @endif
                    {{ $productLang->characteristic }}
                  </a>
                </div>
                <ul itemprop="description" class="listing-features">
                  @foreach ($product->options as $option)
                    <?php $data = json_decode($option->data, true); ?>
                    @if (in_array($data[$lang]['data'], ['Тип обьекта', 'Type of property', 'Количество комнат', 'Number of rooms', 'Комнаты', 'Rooms']))
                      <?php $titles = json_decode($option->title, true); ?>
                      <li>{{ $data[$lang]['data'] }} <span>{{ $titles[$lang]['title'] }}</span></li>
                    @endif
                  @endforeach
                </ul>
              </div>
            </div>
          </div>
        @endif
        <?php if ($i++ == 3) : $i = 1; ?>
          <div class="clearfix"></div>
        <?php endif; ?>
      @endforeach

    </div>
  </section>


  <!-- Advantages  -->
  <section class="parallax margin-bottom-70-"
    data-background="/img/nur-sultan.jpg"
    data-color="#36383e"
    data-color-opacity="0.5"
    data-img-width="800"
    data-img-height="505">

    <!-- Advantages Section -->
    <div class="text-content white-font">
      <div class="container">
        <?php $advantages = $section->firstWhere('slug', 'advantages'); ?>
        @if ($advantages != NULL)
          {!! $advantages->content !!}
        @endif
      </div>
    </div>
  </section>

  <!-- Clients  -->
  <section class="text-content clients">
    <div class="container">
      <div class="row">
        <?php $сlients = $section->firstWhere('slug', 'сlients'); ?>
        <div class="col-lg-6 col-sm-4">
          <h3 class="header-style text-blue display-1">{{ $сlients->title }}</h3><br>
        </div>
        <div class="col-lg-6 col-sm-8">
          <br>
          <p>{!! $сlients->content !!}</p>
        </div>
      </div>
    </div>
  </section>

  <?php $news = $pages->where('lang', $lang)->firstWhere('slug', 'news'); ?>
  @unless($news == null)
    <!-- Fullwidth Section -->
    <section class="fullwidth margin-top-0 margin-bottom-0">

      <!-- Box Headline -->
      <h3 class="headline-box">{{ $pages->firstWhere('slug', 'news')->title }}</h3>

      <div class="container">
        <div class="row">
          @foreach ($posts as $post)
            <div class="col-sm-6 col-md-4">
              <div itemscope itemtype="http://schema.org/Article" class="blog-post">
                <div class="post-content">
                  <h4 itemprop="headline"><a href="/{{ $lang }}/news/{{ $post->slug }}">{{ $post->title }}</a></h4>
                  <div itemprop="articleBody">{!! Str::limit(strip_tags($post->content), 200) !!}</div>
                  <div class="clearfix"></div>
                  <a href="/{{ $lang }}/news/{{ $post->slug }}" class="read-more">{{ __('Read More') }} <i class="fa fa-angle-right"></i></a>
                </div>
              </div>
            </div>
          @endforeach
          <div class="col-md-12 text-center margin-top-25">
            <a href="/{{ $lang }}/i/{{ $pages->firstWhere('slug', 'news')->slug }}" class="button border">{{ $pages->firstWhere('slug', 'news')->title }}</a>
          </div>
        </div>
      </div>
    </section>
  @endunless

@endsection

@section('scripts')

@endsection