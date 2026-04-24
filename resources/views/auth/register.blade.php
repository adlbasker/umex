@extends('layouts.joystick-guest')

@section('content')
<div class="panel panel-default">
  <div class="panel-heading">{{ __('Register') }}</div>

  <div class="panel-body">
    @include('components.alerts')

    <form class="form-horizontal" method="POST" action="{{ route('register', app()->getLocale()) }}">
      @csrf

      <div class="form-group @error('name') has-error @enderror">
        <label for="name" class="col-md-4 control-label">{{ __('Name') }}</label>

        <div class="col-md-6">
          <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

          @error('name')
            <span class="help-block" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>

      <div class="form-group @error('lastname') has-error @enderror">
        <label for="lastname" class="col-md-4 control-label">{{ __('Last name') }}</label>

        <div class="col-md-6">
          <input id="lastname" type="text" class="form-control" name="lastname" value="{{ old('lastname') }}" required autocomplete="family-name">

          @error('lastname')
            <span class="help-block" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>

      <div class="form-group @error('email') has-error @enderror">
        <label for="email" class="col-md-4 control-label">{{ __('E-Mail Address') }}</label>

        <div class="col-md-6">
          <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email">

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
          <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">

          @error('password')
            <span class="help-block" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>

      <div class="form-group">
        <label for="password-confirm" class="col-md-4 control-label">{{ __('Confirm Password') }}</label>

        <div class="col-md-6">
          <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
        </div>
      </div>

      <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
          <button type="submit" class="btn btn-primary">
            {{ __('Register') }}
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
