@extends('layouts.joystick-app')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">{{ __('Confirm Password') }}</div>

    <div class="panel-body">
        <p>{{ __('Please confirm your password before continuing.') }}</p>

        <form class="form-horizontal" method="POST" action="{{ route('password.confirm', app()->getLocale()) }}">
            @csrf

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
                    <button type="submit" class="btn btn-primary">
                        {{ __('Confirm Password') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
