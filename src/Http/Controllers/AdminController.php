<?php

namespace TypiCMS\Modules\Objects\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Objects\Http\Requests\FormRequest;
use TypiCMS\Modules\Objects\Models\Object;

class AdminController extends BaseAdminController
{
    public function index(): View
    {
        return view('objects::admin.index');
    }

    public function create(): View
    {
        $model = new Object();

        return view('objects::admin.create')
            ->with(compact('model'));
    }

    public function edit(object $object): View
    {
        return view('objects::admin.edit')
            ->with(['model' => $object]);
    }

    public function store(FormRequest $request): RedirectResponse
    {
        $object = Object::create($request->validated());

        return $this->redirect($request, $object);
    }

    public function update(object $object, FormRequest $request): RedirectResponse
    {
        $object->update($request->validated());

        return $this->redirect($request, $object);
    }
}
