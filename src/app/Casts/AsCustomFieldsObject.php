<?php

namespace Ipsum\Admin\app\Casts;

use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;

class AsCustomFieldsObject implements Castable
{
    /**
     * Get the caster class to use when casting from / to this cast target.
     *
     * @param  array  $arguments
     * @return object|string
     */
    public static function castUsing(array $arguments)
    {
        return new class implements CastsAttributes
        {
            public function get($model, $key, $value, $attributes)
            {
			
				// Dans le cas ou l'on fait un new Model()
                if (! array_key_exists($key, $attributes)) {
                    return new CustomFields();
                }

                $data = $attributes[$key] !== null ? json_decode($attributes[$key], true) : null;

                return new CustomFields($data);
            }

            public function set($model, $key, $value, $attributes)
            {
                if (is_array($value)) {
                    // Suppression des champs vides
                    $custom_fields = array_filter($value);

                    return json_encode($custom_fields);
                }

                // Cas ou l'on modifie l'attribut custom fields via une porpriétée
                if (is_object($value) and get_class($value) == CustomFields::class) {
                    $custom_fields = get_object_vars($value);
                    return json_encode($custom_fields['fields']);
                }
				
                if (is_null($value)) {
                    return null;
                }

                throw new InvalidArgumentException('The given value is not a array');
            }

            public function serialize($model, string $key, $value, array $attributes)
            {
                return $value->getArrayCopy();
            }
        };
    }
}
