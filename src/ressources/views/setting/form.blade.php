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
                        @switch($setting->type)
                            @case('checkbox')
                            <input type="hidden" name="{{ 'form_'.$setting->id }}" value="0">
                            {{ Aire::checkbox('form_'.$setting->id, $setting->name)->value(1)->checked($setting->value) }}
                            @break

                            @case('select')
                            {{ Aire::select($setting->options, 'form_'.$setting->id, $setting->name)->value($setting->value) }}
                            @break

                            @case('radio')
                            {{ Aire::radioGroup($setting->options, 'form_'.$setting->id, $setting->name)->value($setting->value) }}
                            @break

                            @default
                            {{ Aire::{$setting->type}('form_'.$setting->id, $setting->name)->value($setting->value) }}
                        @endswitch
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
