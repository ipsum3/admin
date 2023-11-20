@switch($type)
    @case('checkbox')
        <input type="hidden" name="{{ $name }}" value="0">
        {{ Aire::checkbox($name, $label)->value(1)->checked( $value )->helpText((string) $description) }}
        @break

    @case('select')
        {{ Aire::select($options, $name, $label)->value( $value )->helpText((string) $description) }}
        @break

    @case('radio')
        {{ Aire::radioGroup($options, $name, $label)->value( $value )->helpText((string) $description) }}
        @break

    @case('html-simple')
        {{ Aire::textArea($name, $label)->class('tinymce-simple')->value($value)->helpText((string) $description)->data('medias', route('admin.media.popin')) }}
        @break

    @case('html')
        {{ Aire::textArea($name, $label)->class('tinymce')->value($value)->helpText((string) $description)->data('medias', route('admin.media.popin')) }}
        @break

    @case('relation')
        {{ Aire::select($options, $name, $label)->value( $value )->helpText((string) $description) }}
        @break

    @case('repeater')
        @php
            $key = uniqid();
        @endphp
        <div class="box" id="bloc_{{ $key }}">
            <div class="box-header">
                <h2 class="box-title">
                    {{ $field['label'] }}
                    @if (!empty($field['description']))
                        <span class="text-muted">{{ $field['description'] }}</span>
                    @endif
                </h2>
                <div class="btn-toolbar">
                    <div class="btn copy-custom-field-btn" data-field_id="{{ $key }}" data-toggle="tooltip" title="Dupliquer"><span class="fa fa-copy"></span></div>
                </div>
            </div>
            <div class="box-body">
                <div id="fields-bloc-{{ $key }}" class="fields-bloc sortable">
                    @php
                        $value = old($name, $value);
                        $i = 0;
                    @endphp
                    @forelse ($value as $group_key => $group_value)
                        @include('IpsumAdmin::components/_repeater', ['i' => $i, 'group_key' => $group_key])
                        @php
                            $i++;
                        @endphp
                    @empty
                        @include('IpsumAdmin::components/_repeater', ['i' => 0, 'group_key' => null])
                    @endforelse

                    <div id="customFields-clone{{ $key }}-template" class="x-tmpl-mustache d-none">
                        @include('IpsumAdmin::components/_repeater', ['i' => '@{{ indice }}', 'group_key' => null])
                    </div>
                </div>
            </div>
        </div>

        @break

    @default
        {{ Aire::{$type}($name, $label)->value( $value )->helpText((string) $description) }}
@endswitch
