<?php

use App\Livewire\Forms\LoginForm;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.joystick-guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: RouteServiceProvider::HOME, navigate: true);
    }
}; ?>

@section('link')
  <a href="/{{ app()->getLocale() }}/register">{{ __('Register') }}</a>
@endsection

<div class="panel panel-default">
  <div class="panel-heading">Вход в систему</div>
  <div class="panel-body">

  	@include('components.alerts')
    
    <form wire:submit="login">

      <div class="form-group">
        <label for="email">{{ __('E-Mail') }}:</label>
        <input id="email" wire:model="form.email" type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus autocomplete="username">

        @if ($errors->has('email'))
          <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('email') }}</strong>
          </span>
        @endif
      </div>

      <div class="form-group">
        <label for="password">{{ __('Password') }}:</label>
        <input id="password" wire:model="form.password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

        @if ($errors->has('password'))
          <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('password') }}</strong>
          </span>
        @endif
      </div>

      <div class="form-group">
          <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
      </div>
    </form>
  </div>
</div>
