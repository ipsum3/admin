@props(['name', 'label', 'description', 'value', 'type' => 'input'])

@switch($type)
    @case('checkbox')
    <input type="hidden" name="{{ $name }}" value="0">
    {{ Aire::checkbox($name, $label)->value(1)->checked($value)->helpText((string) $description) }}
    @break

    @case('select')
    {{ Aire::select($options, $name, $label)->value($value)->helpText((string) $description) }}
    @break

    @case('radio')
    {{ Aire::radioGroup($options, $name, $label)->value($value)->helpText((string) $description) }}
    @break

    @default
    {{ Aire::{$type}($name, $label)->value($value)->helpText((string) $description) }}
@endswitch