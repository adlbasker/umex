@extends('layouts.joystick-guest')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">{{ __('Reset Password') }}</div>

    <div class="panel-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form class="form-horizontal" method="POST" action="{{ route('password.email', app()->getLocale()) }}">
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

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Send Password Reset Link') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
