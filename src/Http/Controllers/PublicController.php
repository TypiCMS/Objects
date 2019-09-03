<?php

namespace TypiCMS\Modules\Objects\Http\Controllers;

use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Objects\Models\Object;

class PublicController extends BasePublicController
{
    public function index(): View
    {
        $models = Object::published()->with('image')->get();

        return view('objects::public.index')
            ->with(compact('models'));
    }

    public function show($slug): View
    {
        $model = Object::published()->bySlug($slug)->firstOrFail();

        return view('objects::public.show')
            ->with(compact('model'));
    }
}
