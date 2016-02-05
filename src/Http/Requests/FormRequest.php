<?php

namespace TypiCMS\Modules\Objects\Http\Requests;

use TypiCMS\Modules\Core\Http\Requests\AbstractFormRequest;

class FormRequest extends AbstractFormRequest
{
    public function rules()
    {
        return [
            'image'   => 'image|max:2000',
            '*.title' => 'max:255',
            '*.slug'  => 'max:255',
        ];
    }
}
