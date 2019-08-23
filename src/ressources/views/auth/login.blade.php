@extends('IpsumAdmin::layouts.login')

@section('content')
    <form class="box l-single-inner" method="POST" action="{{ route('admin.login') }}">
        @csrf
        <h1 class="h1 mb-5 text-center">{{ __('IpsumAdmin::auth.Connexion administration') }}</h1>
        <div class="form-group">
            <label for="inputEmail" class="sr-only">{{ __('IpsumAdmin::auth.Adresse email') }}</label>
            <input type="email" id="inputEmail" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="{{ __('IpsumAdmin::auth.Adresse email') }}" required autofocus>
            @if ($errors->has('email'))
            <div class="invalid-feedback">{{ $errors->first('email') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="inputPassword" class="sr-only">{{ __('IpsumAdmin::auth.Mot de passe') }}</label>
            <input type="password" id="inputPassword" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>
            @if ($errors->has('password'))
            <div class="invalid-feedback">{{ $errors->first('password') }}</div>
            @endif
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMe" value="remember-me" {{ old('remember') ? 'checked' : '' }}>
                        <label class="for-check-label" for="rememberMe"> {{ __('IpsumAdmin::auth.Se souvenir de moi') }}</label>
                    </div>
                </div>
                <div class="col-md-6 text-right">
                    <a href="{{ route('admin.password.request') }}">{{ __('IpsumAdmin::auth.Mot de passe perdu ?') }}</a>
                </div>
            </div>
        </div>

        <button class="btn btn-lg btn-primary btn-block mt-5" type="submit">{{ __('IpsumAdmin::auth.Connexion') }}</button>

    </form>
@endsection
