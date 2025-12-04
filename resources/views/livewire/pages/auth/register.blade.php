<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.joystick-guest')] class extends Component
{
    public string $name = '';
    public string $lastname = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(RouteServiceProvider::HOME, navigate: true);
    }
}; ?>

@section('link')
  <a href="/{{ app()->getLocale() }}/login">{{ __('Login') }}</a>
@endsection

<div class="panel panel-default">
  <div class="panel-heading">Регистрациия</div>
  <div class="panel-body">

    @include('components.alerts')

    <form wire:submit="register">

      <div class="form-group">
        <label for="name">{{ __('Name') }}:</label>
        <input id="name" wire:model="form.name" type="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ $name ?? old('name') }}" required autofocus autocomplete="username">

        @if ($errors->has('name'))
          <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('name') }}</strong>
          </span>
        @endif
      </div>

      <div class="form-group">
        <label for="lastname">{{ __('Lastname') }}:</label>
        <input id="lastname" wire:model="form.lastname" type="lastname" class="form-control {{ $errors->has('lastname') ? 'is-invalid' : '' }}" name="lastname" value="{{ $lastname ?? old('lastname') }}" required autofocus autocomplete="username">

        @if ($errors->has('lastname'))
          <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('lastname') }}</strong>
          </span>
        @endif
      </div>

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
        <input id="password" wire:model="form.password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required autocomplete="new-password">

        @if ($errors->has('password'))
          <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('password') }}</strong>
          </span>
        @endif
      </div>

      <div class="form-group">
        <label for="password_confirmation">{{ __('Confirm Password') }}:</label>
        <input id="password_confirmation" wire:model="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

        @if ($errors->has('password_confirmation'))
          <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('password_confirmation') }}</strong>
          </span>
        @endif
      </div>

      <div class="form-group">
        <button type="submit" class="btn btn-primary">{{ __('Register') }}</button>
      </div>
    </form>
  </div>
</div>
