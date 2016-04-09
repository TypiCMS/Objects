<?php

namespace TypiCMS\Modules\Objects\Http\Controllers;

use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Objects\Http\Requests\FormRequest;
use TypiCMS\Modules\Objects\Models\Object;
use TypiCMS\Modules\Objects\Repositories\ObjectInterface;

class AdminController extends BaseAdminController
{
    public function __construct(ObjectInterface $object)
    {
        parent::__construct($object);
    }

    /**
     * List models.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $models = $this->repository->all([], true);
        app('JavaScript')->put('models', $models);

        return view('objects::admin.index');
    }

    /**
     * Create form for a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $model = $this->repository->getModel();

        return view('objects::admin.create')
            ->with(compact('model'));
    }

    /**
     * Edit form for the specified resource.
     *
     * @param \TypiCMS\Modules\Objects\Models\Object $object
     *
     * @return \Illuminate\View\View
     */
    public function edit(Object $object)
    {
        return view('objects::admin.edit')
            ->with(['model' => $object]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \TypiCMS\Modules\Objects\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FormRequest $request)
    {
        $object = $this->repository->create($request->all());

        return $this->redirect($request, $object);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \TypiCMS\Modules\Objects\Models\Object            $object
     * @param \TypiCMS\Modules\Objects\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Object $object, FormRequest $request)
    {
        $this->repository->update($request->all());

        return $this->redirect($request, $object);
    }
}
