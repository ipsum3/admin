@switch($type)
    @case('checkbox')
        <input type="hidden" name="{{ $name }}" value="0">
        {{ Aire::checkbox($name, $label)->value(1)->checked( $value )->helpText((string) $description) }}
        @break

    @case('select')
        {{ Aire::select($options, $name, $label)->value( $value )->helpText((string) $description) }}
        @break

    @case('select-multiple')
        @php
            $multipleName = $name . '[]';
            $selectedValues = is_array($value) ? $value : ($value ? (array) $value : []);
        @endphp

        <div class="form-group">
            <label for="{{ $name }}">{{ $label }}</label>

            {{-- évite l'absence de clé si aucun choix --}}
            <input type="hidden" name="{{ $multipleName }}" value=" ">

            <select
                    id="{{ $name }}"
                    class="js-example-basic-single form-control"
                    name="{{ $multipleName }}"
                    multiple="multiple"
            >
                @foreach($options as $key => $option)
                    <option value="{{ $key }}"
                            {{ $key != '' && in_array($key, $selectedValues) ? 'selected' : '' }}>
                        {{ $option }}
                    </option>
                @endforeach
            </select>

            @if($description)
                <small class="form-text text-muted">{{ $description }}</small>
            @endif
        </div>
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

    @case('relation-multiple')
        @php
            $multipleName = $name . '[]';

            // $value peut être une Collection, un tableau ou null
            if ($value instanceof \Illuminate\Support\Collection) {
                $selectedValues = $value->toArray();
            } else {
                $selectedValues = is_array($value) ? $value : [];
            }
        @endphp

        <div class="form-group">
            <label for="{{ $name }}">{{ $label }}</label>

            <input type="hidden" name="{{ $multipleName }}" value=" ">

            <select
                    id="{{ $name }}"
                    class="js-example-basic-single form-control"
                    name="{{ $multipleName }}"
                    multiple="multiple"
            >
                @foreach($options as $id => $labelOption)
                    <option value="{{ $id }}"
                            {{ $id != '' && in_array($id, $selectedValues) ? 'selected' : '' }}>
                        {{ $labelOption }}
                    </option>
                @endforeach
            </select>

            @if($description)
                <small class="form-text text-muted">{{ $description }}</small>
            @endif
        </div>
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
                    <div class="btn copy-custom-field-btn" data-field_id="{{ $key }}" data-toggle="tooltip" title="Ajouter"><span class="fa fa-plus"></span></div>
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

    @case('table')
        @php
            $rawValue = old($name, $value);
            if (is_string($rawValue)) {
                $tableValue = json_decode($rawValue, true) ?? [];
            } elseif (is_array($rawValue) || is_object($rawValue)) {
                $tableValue = $rawValue;
            }  elseif (is_object($rawValue)) {
                $tableValue = $rawValue;
            } else {
                $tableValue = [];
            }

            $columns = $field['columns'] ?? [];
            $tableKey = uniqid('table_');
        @endphp

        <div class="box" id="{{ $tableKey }}">
            <div class="box-header">
                <h2 class="box-title">
                    {{ $label }}
                    @if($description)
                        <span class="text-muted">{{ $description }}</span>
                    @endif
                </h2>

                <div class="btn-toolbar">
                    <button class="btn btn-outline-secondary table-editable-add" data-target="tables_{{ $tableKey }}" id="tables_{{ $tableKey }}-add" type="button" data-toggle="tooltip" title="Ajouter" data-table="{{ $tableKey }}">
                        <i class="fas fa-plus"></i> Ajouter une ligne
                    </button>
                </div>
            </div>

            <div class="box-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        @foreach($columns as $column)
                            <th>{{ $column['label'] }}</th>
                        @endforeach
                        <th width="102px"></th>
                    </tr>
                    </thead>

                    <tbody id="tables_{{ $tableKey }}-lignes" class="table-rows sortable">
                    @forelse($tableValue as $index => $row)
                        <tr class="sortable-item"  data-sortable="{{ $index }}">
                            @foreach($columns as $column)
                                <td>
                                    <input
                                            type="text"
                                            class="form-control"
                                            name="{{ $name }}[{{ $index }}][{{ $column['name'] }}]"
                                            value="{{ $row->{$column['name']} ?? null }}"
                                    >
                                </td>
                            @endforeach
                            <td>
                                <div class="btn sortable-move" data-toggle="tooltip" title="Trier"><span class="fa fa-arrows-alt"></span></div>
                                <button type="button" class="tables_{{ $tableKey }}-delete btn btn-outline-danger" data-confirm="false"><i class="fa fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    @empty
                        <tr class="sortable-item" data-sortable="{{ $index }}">
                            @foreach($columns as $column)
                                <td>
                                    <input
                                            type="text"
                                            class="form-control"
                                            name="{{ $name }}[0][{{ $column['name'] }}]"
                                    >
                                </td>
                            @endforeach
                            <td>
                                <div class="btn sortable-move" data-toggle="tooltip" title="Trier"><span class="fa fa-arrows-alt"></span></div>
                                <button type="button" class="tables_{{ $tableKey }}-delete btn btn-outline-danger" data-confirm="false"><i class="fa fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    @endforelse

                        <script id="tables_{{ $tableKey }}-add-template" type="x-tmpl-mustache">
                            <tr class="sortable-item"  data-sortable="{{ $index }}">
                                @foreach($columns as $column)
                                    <td>
                                        <input type="text" class="form-control" name="{{ $name }}[@{{ indice }}][{{ $column['name'] }}]">
                                    </td>
                                @endforeach
                                <td>
                                    <div class="btn sortable-move" data-toggle="tooltip" title="Trier"><span class="fa fa-arrows-alt"></span></div>
                                    <button type="button" class="tables_{{ $tableKey }}-delete btn btn-outline-danger" data-confirm="false"><i class="fa fa-trash-alt"></i></button>
                                </td>
                            </tr>
                        </script>
                    </tbody>
                </table>
            </div>
        </div>
        @break

    @default
        {{ Aire::{$type}($name, $label)->value( $value )->helpText((string) $description) }}
@endswitch
