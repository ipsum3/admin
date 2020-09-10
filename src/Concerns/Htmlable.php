<?php

namespace Ipsum\Admin\Concerns;


use GrahamCampbell\Security\Facades\Security;
use voku\helper\AntiXSS;

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

                    // Problème avec plugin GrahamCampbell et iframe
                    //$objet->$champ = Security::clean($objet->$champ);

                    $antiXss = new AntiXSS();
                    $antiXss->removeEvilHtmlTags(array('iframe'));
                    $objet->$champ = $antiXss->xss_clean($objet->$champ);
                }
            }
        });

    }


}
