@extends('layouts.joystick-guest')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">{{ __('Reset Password') }}</div>

    <div class="panel-body">
        <form class="form-horizontal" method="POST" action="{{ route('password.store', app()->getLocale()) }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group @error('email') has-error @enderror">
                <label for="email" class="col-md-4 control-label">{{ __('E-Mail Address') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

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
                        {{ __('Reset Password') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
