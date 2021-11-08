<?php

namespace TypiCMS\Modules\Objects\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Objects\Exports\Export;
use TypiCMS\Modules\Objects\Http\Requests\FormRequest;
use TypiCMS\Modules\Objects\Models\Object;

class AdminController extends BaseAdminController
{
    public function index(): View
    {
        return view('objects::admin.index');
    }

    public function export(Request $request)
    {
        $filename = date('Y-m-d').' '.config('app.name').' objects.xlsx';

        return Excel::download(new Export(), $filename);
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
