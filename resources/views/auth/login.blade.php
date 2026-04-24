@extends('layouts.joystick-guest')

@section('content')
<div class="panel panel-default">
  <div class="panel-heading">{{ __('Login') }}</div>

  <div class="panel-body">
    @include('components.alerts')

    <form class="form-horizontal" method="POST" action="{{ route('login', app()->getLocale()) }}">
      @csrf

      <div class="form-group @error('email') has-error @enderror">
        <label for="email" class="col-md-4 control-label">{{ __('E-Mail Address') }}</label>

        <div class="col-md-6">
          <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

          @error('email')
            <span class="help-block" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>

      <div class="form-group @error('password') has-error @enderror">
        <label for="password" class="col-md-4 control-label">{{ __('Password') }}</label>

        <div class="col-md-6">
          <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">

          @error('password')
            <span class="help-block" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>

      <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
          <div class="checkbox">
            <label for="remember">
              <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
              {{ __('Remember Me') }}
            </label>
          </div>
        </div>
      </div>

      <div class="form-group">
        <div class="col-md-8 col-md-offset-4">
          <button type="submit" class="btn btn-primary">
            {{ __('Login') }}
          </button>

          @if (Route::has('password.request'))
            <a class="btn btn-link" href="{{ route('password.request', app()->getLocale()) }}">
              {{ __('Forgot Your Password?') }}
            </a>
          @endif
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
