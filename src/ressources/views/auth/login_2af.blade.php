@extends('IpsumAdmin::layouts.login')

@section('content')
    <form class="box l-single-inner" method="POST" action="{{ route('admin.login.send2af', session()->has('admin_waiting_for_2af')) }}">
        @csrf
        <h1 class="h1 mb-3 text-center">Validation en deux étapes</h1>
        @if(session()->has('error'))
            <div class="alert alert-danger" role="alert">
                {{ session()->get('error') }}
            </div>
        @endif
        <div class="alert alert-light alert-dismissible fade show" role="alert">
            <div class="alert-icon">
                <i class="fas fa-info-circle"></i>
            </div>
            <div class="alert-text">
                <small>Veuillez entrer le code généré par votre application (<a href="https://support.1password.com/one-time-passwords/" title="1Password" target="_blank" rel="noreferrer ugc nofollow">1Password</a>, <a href="https://authy.com/guides/github/" title="Authy" target="_blank" rel="noreferrer ugc nofollow">Authy</a>, <a href="https://www.microsoft.com/en-us/account/authenticator/" title="Microsoft Authenticator" target="_blank" rel="noreferrer ugc nofollow">Microsoft Authenticator</a>) :</small>
            </div>
        </div>
        <div class="form-group">
            <p class="text-center"></p>
            <label for="secret_temp" class="sr-only">{{ __('IpsumAdmin::auth.Adresse email') }}</label>
            <input type="text" id="secret_temp" class="form-control" name="secret_temp"  placeholder="{{ __('Code à 6 chiffres') }}" required autofocus>
        </div>
        <input type="hidden" name="remember" value="{{ session()->get('remember') }}">



        <button class="btn btn-lg btn-primary btn-block mt-3" type="submit">Valider</button>

    </form>
@endsection
