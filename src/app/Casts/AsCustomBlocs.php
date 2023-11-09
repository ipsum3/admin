<?php

namespace Ipsum\Admin\app\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Collection;
use voku\helper\AntiXSS;

class AsCustomBlocs implements CastsAttributes
{
    public function get($model, $key, $value, $attributes)
    {

        // Dans le cas où l'on fait un new Model()
        if (! isset($attributes[$key])) {
            return new Collection();
        }

        $datas = json_decode($attributes[$key], true);
        $datas = is_array($datas) ? $datas : null;

        $custom_blocs = new Collection($datas);

        $custom_blocs = $this->convertFieldsToCustomFieldsObject($custom_blocs);

        return $custom_blocs;
    }

    public function set($model, $key, $value, $attributes)
    {
        return json_encode($value);
    }

    protected function convertFieldsToCustomFieldsObject($datas)
    {
        return $datas->map(function ($bloc, int $key) {
            if (is_array($bloc) && isset($bloc['fields']) && is_array($bloc['fields'])) {
                $bloc['fields'] = new CustomFields($bloc['fields']);
                return (object) $bloc;
            }
            return null;
        });
    }

}