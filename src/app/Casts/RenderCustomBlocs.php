<?php

namespace Ipsum\Admin\app\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class RenderCustomBlocs implements CastsAttributes
{
    public function get($model, $key, $value, $attributes)
    {
        $custom_blocs = $model->custom_blocs;

        if (!$custom_blocs) {
            return $custom_blocs;
        }

        $customViewPath = config('ipsum.article.custom_bloc_path');
        $output = $attributes['texte'];

        foreach ($custom_blocs as $key => $bloc) {
            $viewName = '_'.$bloc->name;
            $fullViewPath = $customViewPath . '.' . $viewName;
            if (view()->exists($fullViewPath) && isset($bloc->fields)) {
                dump($bloc);

                $output .= view($fullViewPath, ['key' => $key, 'bloc' => $bloc->fields ])->render();
            }
        }

        return $output;
    }

    public function set($model, $key, $value, $attributes)
    {
        return $value;
    }
}
