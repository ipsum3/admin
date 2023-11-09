<?php

namespace Ipsum\Admin\app\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class RenderCustomBlocs implements CastsAttributes
{

    protected $champ_complementaire;
    protected $champ_custom_blocs;

    public function __construct(string $champ_custom_blocs = 'custom_blocs', string $champ_complementaire = 'texte')
    {
        $this->champ_complementaire = $champ_complementaire;
        $this->champ_custom_blocs = $champ_custom_blocs;
    }

    public function get($model, $key, $value, $attributes)
    {
        if (! isset($attributes[$this->champ_complementaire]) or ! isset($attributes[$this->champ_custom_blocs])) {
            return null;
        }

        $custom_blocs = $model->{$this->champ_custom_blocs};
        $custom_view_directory = config('ipsum.admin.custom_bloc_view_directory');
        $output = $model->{$this->champ_complementaire};

        foreach ($custom_blocs as $key => $bloc) {
            $view = $custom_view_directory . '.' . '_'.$bloc->name;
            if (view()->exists($view) and isset($bloc->fields)) {
                $output .= view($view, ['key' => $key, 'bloc' => $bloc->fields ])->render();
            }
        }

        return $output;
    }

    public function set($model, $key, $value, $attributes)
    {
        return null;
    }
}
