<?php

namespace Ipsum\Admin\app\Casts;

class CustomFields
{
    public $fields = [];

    public function __construct( ?Array $fields = [] ) {
        $this->fields = is_array($fields) ? $fields : [];
    }

    public function __get( $name ) {
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
