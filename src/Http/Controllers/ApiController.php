<?php

namespace TypiCMS\Modules\Objects\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Files\Models\File;
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

    protected function updatePartial(object $object, Request $request)
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

    public function destroy(object $object)
    {
        $object->delete();
    }

    /**
     * @deprecated
     */
    public function files(object $object): Collection
    {
        return $object->files;
    }

    /**
     * @deprecated
     */
    public function attachFiles(object $object, Request $request): JsonResponse
    {
        return $object->attachFiles($request);
    }

    /**
     * @deprecated
     */
    public function detachFile(object $object, File $file): void
    {
        $object->detachFile($file);
    }
}
