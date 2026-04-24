@extends('layouts.joystick-app')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">{{ __('Verify Your Email Address') }}</div>

    <div class="panel-body">
        @if (session('status') === 'verification-link-sent')
            <div class="alert alert-success" role="alert">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
        @endif

        <p>{{ __('Before proceeding, please check your email for a verification link.') }}</p>
        <div>
            {{ __('If you did not receive the email') }},
            <form class="form-inline" method="POST" action="{{ route('verification.send', app()->getLocale()) }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-link">{{ __('click here to request another') }}</button>.
            </form>
        </div>
    </div>
</div>
@endsection
