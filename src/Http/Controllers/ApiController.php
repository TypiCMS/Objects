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

    protected function updatePartial(Object $object, Request $request): JsonResponse
    {
        $data = [];
        foreach ($request->all() as $column => $content) {
            if (is_array($content)) {
                foreach ($content as $key => $value) {
                    $data[$column.'->'.$key] = $value;
                }
            } else {
                $data[$column] = $content;
            }
        }

        foreach ($data as $key => $value) {
            $object->$key = $value;
        }
        $saved = $object->save();

        return response()->json([
            'error' => !$saved,
        ]);
    }

    public function destroy(Object $object): JsonResponse
    {
        $deleted = $object->delete();

        return response()->json([
            'error' => !$deleted,
        ]);
    }

    /**
     * @deprecated
     */
    public function files(Object $object): Collection
    {
        return $object->files;
    }

    /**
     * @deprecated
     */
    public function attachFiles(Object $object, Request $request): JsonResponse
    {
        return $object->attachFiles($request);
    }

    /**
     * @deprecated
     */
    public function detachFile(Object $object, File $file): void
    {
        $object->detachFile($file);
    }
}
