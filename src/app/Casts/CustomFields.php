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


}
