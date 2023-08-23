<?php

namespace Ipsum\Admin\Concerns;


use GrahamCampbell\Security\Facades\Security;
use voku\helper\AntiXSS;

trait Htmlable
{

    public function setAttribute($key, $value)
    {
        if ($this->isTtmlableAttribute($key) and $value !== null) {

            $antiXss = new AntiXSS();
            $antiXss->removeEvilHtmlTags(config('ipsum.admin.remove_evil_html_tags'));
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
