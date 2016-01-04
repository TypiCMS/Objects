<?php

namespace TypiCMS\Modules\Objects\Models;

use TypiCMS\Modules\Core\Models\BaseTranslation;

class ObjectTranslation extends BaseTranslation
{
    /**
     * get the parent model.
     */
    public function owner()
    {
        return $this->belongsTo('TypiCMS\Modules\Objects\Models\Object', 'object_id');
    }
}
