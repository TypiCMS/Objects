<?php

namespace TypiCMS\Modules\Objects\Http\Controllers;

use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Objects\Http\Requests\FormRequest;
use TypiCMS\Modules\Objects\Models\Object;

class AdminController extends BaseAdminController
{
    /**
     * List models.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('objects::admin.index');
    }

    /**
     * Create form for a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $model = new;

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
        $object = ::create($request->all());

        return $this->redirect($request, $object);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \TypiCMS\Modules\Objects\Models\Object             $object
     * @param \TypiCMS\Modules\Objects\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Object $object, FormRequest $request)
    {
        ::update($request->id, $request->all());

        return $this->redirect($request, $object);
    }
}
