<?php

namespace TypiCMS\Modules\Objects\Repositories;

use TypiCMS\Modules\Core\Repositories\EloquentRepository;
use TypiCMS\Modules\Objects\Models\Object;

class EloquentObject extends EloquentRepository
{
    protected $repositoryId = 'objects';

    protected $model = Object::class;
}
