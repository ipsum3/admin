<?php

namespace Ipsum\Admin\Concerns;


use GrahamCampbell\Security\Facades\Security;

trait Htmlable
{

    protected static function bootHtmlable()
    {

        static::saving(function ($objet) {

            if (!property_exists($objet, 'htmlable')){
                return;
            }

            foreach ($objet->htmlable as $champ) {
                if ($objet->$champ !== null) {
                    $objet->$champ = Security::clean($objet->$champ);
                }
            }
        });

    }


}
