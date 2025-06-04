@extends('IpsumAdmin::layouts.app')
@section('title', 'Administrateurs')

@section('content')

    <h1 class="main-title">Méthodes d’authentification</h1>

    {{ Aire::open()->route('admin.2faValidate', $admin) }}

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Double authentification</h3>
        </div>
        <div class="box-body">
            @if(!$admin->secret_totp)
                <div class="row">
                {!! $qr_code !!}
                    <div class="col mt-4">
                        <div class="alert alert-light alert-dismissible fade show" role="alert">
                            <div class="alert-icon">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <div class="alert-text">
                                <p>Les applications d'authentification et les extensions de navigateur telles que <a href="https://support.1password.com/one-time-passwords/" title="1Password" target="_blank" rel="noreferrer ugc nofollow">1Password</a>, <a href="https://authy.com/guides/github/" title="Authy" target="_blank" rel="noreferrer ugc nofollow">Authy</a>, <a href="https://www.microsoft.com/en-us/account/authenticator/" title="Microsoft Authenticator" target="_blank" rel="noreferrer ugc nofollow">Microsoft Authenticator</a>, etc. génèrent des mots de passe à usage unique qui sont utilisés comme deuxième facteur pour vérifier votre identité lorsque vous y êtes invité lors de la connexion.</p>
                                <p>Scannez le code QR avec votre application d'authentification :</p>
                            </div>
                        </div>
                        <hr>
                        <p>Entrez le code à 6 chiffres généré par votre application d'authentification :</p>
                        <form method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="secret" class="form-control" placeholder="Code à 6 chiffres" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Valider</button>
                        </form>
                    </div>
                </div>


            @else
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div class="alert-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="alert-text">
                        La Double Authentification (2FA) est actuellement activée pour votre compte.
                    </div>
                </div>
                <p>Pour désactiver la double authentification, cliquez sur le bouton ci-dessous :</p>
                <form method="POST" action="{{ route('admin.2faDelete', $admin) }}">
                    @csrf
                    @method('DELETE') <!-- Assurez-vous de configurer correctement votre route pour la désactivation -->
                    <button type="submit" class="btn btn-danger">Désactiver la double authentification</button>
                </form>
            @endif
        </div>
    </div>

    {{ Aire::close() }}

@endsection