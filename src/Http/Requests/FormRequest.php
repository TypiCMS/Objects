<?php

namespace TypiCMS\Modules\Objects\Http\Requests;

use TypiCMS\Modules\Core\Http\Requests\AbstractFormRequest;

class FormRequest extends AbstractFormRequest
{
    public function rules()
    {
        $rules = [
            'image' => 'image|max:2000',
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules[$locale.'.title'] = 'max:255';
            $rules[$locale.'.slug'] = 'max:255';
        }

        return $rules;
    }
}
