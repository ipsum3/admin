@extends('IpsumAdmin::layouts.login')

@section('content')
    <form class="box l-single-inner" method="POST" action="{{ route('admin.password.email') }}">
        @csrf
        <h1 class="h1 mb-5 text-center">{{ __('IpsumAdmin::auth.Réinitialisation du mot de passe') }}</h1>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif


        <div class="form-group">
            <label for="inputEmail" class="sr-only">{{ __('IpsumAdmin::auth.Adresse email') }}</label>
            <input type="email" id="inputEmail" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="{{ __('IpsumAdmin::auth.Adresse email') }}" required autofocus>
            @if ($errors->has('email'))
                <div class="invalid-feedback">{{ $errors->first('email') }}</div>
            @endif
        </div>

        <button class="btn btn-lg btn-primary btn-block mt-5" type="submit">{{ __('IpsumAdmin::auth.Envoyer le lien de réinitialisation') }}</button>

        <div class="mt-3 text-center">
            <a href="{{ route('admin.login') }}">{{ __('IpsumAdmin::auth.Connexion') }}</a>
        </div>
    </form>
@endsection
