@extends('layout')

@section('meta_title', $post->meta_title ?? $post->title)

@section('meta_description', $post->meta_description ?? $post->title)

@section('head')

@endsection

@section('content')

<!-- Titlebar -->
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
            <li><a href="/{{ $lang }}/i/{{ $page->slug }}">{{ $page->title }}</a></li>
            <li>{{ $post->title }}</li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</div>

<!-- Content -->
<div class="container">

  @include('partials.notifications')

  <div class="blog-page">
    <div class="row">

      <!-- Post Content -->
      <div class="col-md-8">
        <!-- Blog Post -->
        <div itemscope itemtype="http://schema.org/Article" class="blog-post single-post">
          <div class="post-content">
            <h2 itemprop="headline">{{ $post->title }}</h2>

            <ul itemprop="datePublished" class="post-meta">
              <li>{{ $post->getDateAttribute() }}</li>
              <!-- <li><a href="#">5 Comments</a></li> -->
            </ul>

            <div itemprop="articleBody">{!! $post->content !!}</div>

            <div class="clearfix"></div>
          </div>
        </div>

        <div class="margin-top-50"></div>
      </div>

      <!-- Widgets -->
      <div class="col-md-4">
        <div class="sidebar right">

          <!-- Widget -->
          <div class="widget">
            <div class="agent-widget">
              <form action="/{{ $lang }}/send-app" name="contact" method="post">
                @csrf
                <h3>{{ __('App form') }}</h3>
                <input type="name" name="name" id="name" placeholder="{{ __('Your Name') }}" required>
                <input type="surname" name="surname" id="surname" class="hidden" placeholder="{{ __('Your Surname') }}">
                <input type="tel" pattern="(\+?\d[- .]*){7,13}" name="phone" minlength="5" maxlength="20" placeholder="{{ __('Your Phone') }}" required>
                <textarea name="message" autocomplete="off" required placeholder="{{ __('Your Message') }}"></textarea>
                <button class="button fullwidth margin-top-5">{{ __('Send Message') }}</button>
              </form>
            </div>
          </div>

          <!-- Widget -->
          <!-- <div class="widget">
            <h3 class="margin-top-0 margin-bottom-25">{{ __('Social') }}</h3>
            <ul class="social-icons rounded">
              <li><a class="facebook" href="#"><i class="icon-facebook"></i></a></li>
              <li><a class="instagram" href="#"><i class="icon-instagram"></i></a></li>
            </ul>
          </div> -->

          <div class="clearfix"></div>
          <div class="margin-bottom-40"></div>
        </div>
      </div>
    </div>

  </div>
</div>

@endsection

@section('scripts')

@endsection