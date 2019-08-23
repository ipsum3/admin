@extends('IpsumAdmin::layouts.login')

@section('content')

    <form class="box l-single-inner" method="POST" action="{{ route('admin.password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <h1 class="h1 mb-5 text-center">{{ __('IpsumAdmin::auth.Modifier le mot de passe') }}</h1>
        <div class="form-group">
            <label for="inputEmail" class="sr-only">{{ __('IpsumAdmin::auth.Adresse email') }}</label>
            <input type="email" id="inputEmail" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" placeholder="{{ __('IpsumAdmin::auth.Adresse email') }}" required autofocus>
            @if ($errors->has('email'))
                <div class="invalid-feedback">{{ $errors->first('email') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="inputPassword" class="sr-only">{{ __('IpsumAdmin::auth.Mot de passe') }}</label>
            <input type="password" id="inputPassword" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('IpsumAdmin::auth.Nouveau mot de passe') }}" required>
            @if ($errors->has('password'))
                <div class="invalid-feedback">{{ $errors->first('password') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="inputPasswordConfirm" class="sr-only">{{ __('IpsumAdmin::auth.Confirmation du mot de passe') }}</label>
            <input type="password" id="inputPasswordConfirm" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password_confirmation" placeholder="{{ __('IpsumAdmin::auth.Nouveau mot de passe') }}" required>
        </div>

        <button class="btn btn-lg btn-primary btn-block mt-5" type="submit">{{ __('IpsumAdmin::auth.Modifier le mot de passe') }}</button>
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                </div>
                <div class="col-md-6 text-right">
                    <a href="{{ route('admin.password.request') }}">{{ __('IpsumAdmin::auth.Mot de passe perdu ?') }}</a>
                </div>
            </div>
        </div>

        <div class="mt-3 text-center">
            <a href="{{ route('admin.login') }}">{{ __('IpsumAdmin::auth.Connexion') }}</a>
        </div>
    </form>

@endsection
