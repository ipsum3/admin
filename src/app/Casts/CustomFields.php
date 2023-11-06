<?php

namespace Ipsum\Admin\app\Casts;

use Illuminate\Support\Collection;
use voku\helper\AntiXSS;

class CustomFields
{
    public $fields = [];

    public function __construct( ?Array $fields = [] ) {
        $this->fields = is_array($fields) ? $fields : [];
    }

    public function __get( $name ) {
        if(isset($this->fields[$name]) and (is_array($this->fields[$name]))) {
            $collection = new Collection($this->fields[$name]);
            return $collection->map(function ($item, $name) {
                if(is_array($item)) {
                    return new self($item);
                } else {
                    return $item;
                }
            });
        }

        return $this->fields[$name] ?? null;
    }

    public function __set( $name, $value ) {
        if (is_null($value)) {
            unset($this->fields[$name]);
        } else {
            $this->fields[$name] = $value;
        }
    }

    public function getArrayCopy()
    {
        return $this->fields;
    }
}
