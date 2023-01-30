@extends('IpsumAdmin::layouts.app')
@section('title', 'Administrateurs')

@section('content')

    <h1 class="main-title">Administrateurs</h1>

    {{ Aire::open()->route($admin->exists ? 'adminUser.update' : 'adminUser.store', $admin->exists ? $admin->id : null)->bind($admin)->formRequest(\Ipsum\Admin\app\Http\Requests\StoreAdmin::class) }}
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Modification</h3>
            <div class="btn-toolbar">
                <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> Enregistrer</button>&nbsp;
                <button class="btn btn-outline-secondary" type="reset" data-toggle="tooltip" title="Annuler les modifications en cours"><i class="fas fa-undo"></i></button>&nbsp;
                @if ($admin->exists)
                    @can('update', $admin)
                        <a class="btn btn-outline-secondary" href="{{ route('adminUser.create') }}" data-toggle="tooltip" title="Ajouter">
                            <i class="fas fa-plus"></i>
                        </a>&nbsp;
                        @can('delete', $admin)
                            <a class="btn btn-outline-danger" href="{{ route('adminUser.destroy',$admin) }}" data-toggle="tooltip" title="Supprimer">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        @endcan
                    @endcan
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
            <div class="form-row">
                {{ Aire::select($roles, 'role', 'Rôle*')->groupClass('form-group col-md-6') }}
                <input type="hidden" name="acces" value="">{{-- Pour gérer le cas du select multiple vide --}}
                @can('create', $admin)
                @if ($acces)
                {{ Aire::select($acces, 'acces', 'Accés')->groupClass('form-group col-md-6')->setAttribute('multiple', 'multiple')->addClass('js-example-basic-single js-states')->data('tags', 'true') }}
                @endif
                @endcan()
            </div>
        </div>
    </div>
    {{ Aire::close() }}

@endsection