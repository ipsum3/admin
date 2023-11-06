<div class="field-group mb-5 sortable-item" data-sortable="{{ $i }}" style="box-shadow: 0px 0px 13px 0px rgba(82, 63, 105, 0.2);padding: 28px;">
    @foreach($field['fields'] as $k => $subField)
        @php
            $subFieldName = $name.'['.$i.'][' . $subField['name'] . ']';
            $subFieldValue = old($subFieldName, $value[$group_key]->{$subField['name']} ?? '');
        @endphp
        <x-admin::custom :field="$subField" :name="$subFieldName" :value="$subFieldValue" />
    @endforeach
    <div class="btn-toolbar">
        <button class="btn remove-repeater" type="button" >
            <i class="fas fa-trash"></i>
        </button>
        <div class="btn sortable-move" data-toggle="tooltip" title="Trier"><span class="fa fa-arrows-alt"></span></div>
    </div>
</div>