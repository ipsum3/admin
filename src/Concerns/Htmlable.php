<?php

namespace Ipsum\Admin\Concerns;


use GrahamCampbell\Security\Facades\Security;
use voku\helper\AntiXSS;

trait Htmlable
{

    public function setAttribute($key, $value)
    {
        if ($this->isTtmlableAttribute($key) and $value !== null) {

            // Problème avec plugin GrahamCampbell et iframe
            //$this->$champ = Security::clean($this->$champ);

            $antiXss = new AntiXSS();
            $antiXss->removeEvilHtmlTags(array('iframe'));
            $value = $antiXss->xss_clean($value);
        }

        return parent::setAttribute($key, $value);

    }


    protected function htmlableAttributes() {
        return $this->htmlable;
    }

    protected function isTtmlableAttribute($key)
    {
        return in_array($key, $this->htmlableAttributes());
    }

}
