<?php

namespace TypiCMS\Modules\Objects\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Objects\Models\Object;

class ApiController extends BaseApiController
{
    public function index(Request $request): LengthAwarePaginator
    {
        $data = QueryBuilder::for(Object::class)
            ->selectFields($request->input('fields.objects'))
            ->allowedSorts(['status_translated', 'title_translated'])
            ->allowedFilters([
                AllowedFilter::custom('title', new FilterOr()),
            ])
            ->allowedIncludes(['image'])
            ->paginate($request->input('per_page'));

        return $data;
    }

    protected function updatePartial(Object $object, Request $request)
    {
        foreach ($request->only('status') as $key => $content) {
            if ($object->isTranslatableAttribute($key)) {
                foreach ($content as $lang => $value) {
                    $object->setTranslation($key, $lang, $value);
                }
            } else {
                $object->{$key} = $content;
            }
        }

        $object->save();
    }

    public function destroy(Object $object)
    {
        $object->delete();
    }
}
