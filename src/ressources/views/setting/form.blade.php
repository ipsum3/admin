@extends('IpsumAdmin::layouts.app')
@section('title', 'Paramètres')

@section('content')

    <h1 class="main-title">Paramètres</h1>

    {{ Aire::open()->route('admin.setting.update')->rules($rules) }}
        @foreach($groups as $group_key => $group)
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{ $group_key }}</h3>
                </div>
                <div class="box-body">
                    @foreach($group as $setting)
                        <x-admin::custom
                            name="{{ 'form_'.$setting->id }}"
                            label="{{ $setting->name }}"
                            description="{{ $setting->description }}"
                            value="{{ $setting->value }}"
                            type="{{ $setting->type }}"
                        />
                    @endforeach
                </div>
                <div class="box-footer">
                    <div><button class="btn btn-outline-secondary" type="reset">Annuler</button></div>
                    <div><button class="btn btn-primary" type="submit">Enregistrer</button></div>
                </div>
            </div>
        @endforeach
    {{ Aire::close() }}

@endsection
