@php
$order = isset($order) ? $order : 'desc';

$query = '?';
foreach (request()->except(['tri', 'order']) as $key => $value) {
    $query .= $key.'='.$value.'&';
}
if (request()->filled('tri') and request()->tri == $champ) {
    $order = request()->order == 'desc' ? 'asc' : 'desc';
}

$query .= 'tri='.$champ.'&order='.$order;
@endphp
<a href="{{ $query }}">{{ $label }}</a>