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
                        @php
                            $field = $setting->toArray();
                            $field['label'] = $field['name'];
                            $field_name = 'form_'.$setting->id;
                            $field_value = old( $field_name, $setting->value ?  : ($field['type'] == "repeater" ? [] : '') );
                        @endphp
                        <x-admin::custom :field="$field" :name="$field_name" :value="$field_value"/>
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
