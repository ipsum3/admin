<?php

namespace Ipsum\Admin\app\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use voku\helper\AntiXSS;

class CustomBlocs implements CastsAttributes
{
    public function get($model, $key, $value, $attributes)
    {
        $custom_blocs = json_decode($attributes['custom_blocs'], true);

        // Convertir les champs 'fields' en AsCustomFieldsObject
        $custom_blocs = $this->convertFieldsToCustomFieldsObject((is_array($custom_blocs)) ? $custom_blocs : []);
        $custom_blocs = $this->convertArraysToObjects((is_array($custom_blocs)) ? $custom_blocs : []);

        return $custom_blocs;
    }

    public function set($model, $key, $value, $attributes)
    {
        return json_encode($value);
    }

    protected function convertFieldsToCustomFieldsObject($data)
    {
        foreach ($data as $index => $bloc) {
            if (is_array($bloc) && isset($bloc['fields']) && is_array($bloc['fields'])) {
                $data[$index]['fields'] = new CustomFields($bloc['fields']);
                $data[$index]['fields'] = $this->convertFieldsToCustomFieldsObject($data[$index]['fields']);
            }
        }

        return $data;
    }

    protected function convertArraysToObjects($data)
    {
        if (is_array($data)) {
            foreach ($data as $index => $value) {
                if (is_array($value)) {
                    $data[$index] = $this->convertArraysToObjects((is_array($value)) ? $value : []);
                }
            }
            return (object)$data;
        } else {
            return $data;
        }
    }

}