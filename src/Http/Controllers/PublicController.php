<?php

namespace TypiCMS\Modules\Objects\Http\Controllers;

use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Objects\Repositories\EloquentObject;

class PublicController extends BasePublicController
{
    public function __construct(EloquentObject $object)
    {
        parent::__construct($object);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $models = $this->repository->all();

        return view('objects::public.index')
            ->with(compact('models'));
    }

    /**
     * Show news.
     *
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $model = $this->repository->bySlug($slug);

        return view('objects::public.show')
            ->with(compact('model'));
    }
}
