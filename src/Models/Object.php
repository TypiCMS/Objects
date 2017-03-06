<?php

namespace TypiCMS\Modules\Objects\Models;

use Laracasts\Presenter\PresentableTrait;
use Spatie\Translatable\HasTranslations;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\History\Traits\Historable;
use TypiCMS\Modules\Objects\Presenters\ModulePresenter;

class Object extends Base
{
    use HasTranslations;
    use Historable;
    use PresentableTrait;

    protected $presenter = ModulePresenter::class;

    protected $guarded = ['id', 'exit'];

    public $translatable = [
        'title',
        'slug',
        'status',
        'summary',
        'body',
    ];

    protected $appends = ['thumb', 'title_translated'];

    public $attachments = [
        'image',
    ];

    /**
     * Append title_translated attribute.
     *
     * @return string
     */
    public function getTitleTranslatedAttribute()
    {
        $locale = config('app.locale');
        return $this->translate('title', config('typicms.content_locale', $locale));
    }

    /**
     * Append thumb attribute.
     *
     * @return string
     */
    public function getThumbAttribute()
    {
        return $this->present()->thumbSrc(null, 22);
    }
}
