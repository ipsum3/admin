@extends('IpsumAdmin::layouts.app')
@section('title', 'Administrateurs')

@section('content')

    <h1 class="main-title">Administrateurs</h1>

    {{ Aire::open()->route($admin->exists ? 'adminUser.update' : 'adminUser.store', $admin->exists ? $admin->id : null)->bind($admin)->formRequest(\Ipsum\Admin\app\Http\Requests\StoreAdmin::class) }}
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Modification</h3>
            <div class="btn-toolbar">
                @if ($admin->exists)
                    <a class="btn btn-outline-secondary" href="{{ route('admin.2fa', $admin) }}" data-toggle="tooltip" title="Activer la double authentification"><i class="fas fa-qrcode"></i> Méthodes d’authentification</a>&nbsp;
                @endif
            </div>
        </div>
        <div class="box-body">
            <div class="form-row">
                {{ Aire::input('name', 'Nom*')->placeholder('Votre nom')->groupClass('form-group col-md-6') }}
                {{ Aire::input('firstname', 'Prénom')->groupClass('form-group col-md-6') }}
            </div>
            <div class="form-row">
                {{ Aire::email('email', 'Email*')->groupClass('form-group col-md-6') }}
                {{ Aire::password('password', 'Password')->value('')->groupClass('form-group col-md-6')->autocomplete('new-password') }}
            </div>
            @can('create', $admin)
                <div class="form-row">
                    {{ Aire::select($roles, 'role', 'Rôle*')->groupClass('form-group col-md-6') }}
                    <input type="hidden" name="acces" value="">{{-- Pour gérer le cas du select multiple vide --}}
                    @if ($acces)
                        {{ Aire::select($acces, 'acces', 'Accés')->groupClass('form-group col-md-6')->setAttribute('multiple', 'multiple')->addClass('js-example-basic-single js-states')->data('tags', 'true') }}
                    @endif
                </div>
            @endcan()
        </div>
        <div class="box-footer">
            <div><button class="btn btn-outline-secondary" type="reset">Annuler</button></div>
            <div><button class="btn btn-primary" type="submit">Enregistrer</button></div>
        </div>
    </div>
    {{ Aire::close() }}

@endsection
