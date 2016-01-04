<?php

namespace TypiCMS\Modules\Objects\Repositories;

use Illuminate\Database\Eloquent\Model;
use TypiCMS\Modules\Core\Repositories\RepositoriesAbstract;

class EloquentObject extends RepositoriesAbstract implements ObjectInterface
{
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
