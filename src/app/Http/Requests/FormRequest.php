<?php

namespace Ipsum\Admin\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest as HttpFormRequest;
use Prologue\Alerts\Facades\Alert;

class FormRequest extends HttpFormRequest
{

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($validator->failed()) {
                Alert::warning($validator->getMessageBag()->count() > 1 ? __("Il y a :count erreurs sur ce formulaire que vous devez corriger", ['count' => $validator->getMessageBag()->count()]) : __("Il y a une erreur sur ce formulaire que vous devez corriger"))->flash();
            }
        });
    }
}
