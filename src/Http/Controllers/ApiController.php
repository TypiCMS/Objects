<?php

namespace TypiCMS\Modules\Objects\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\Filter;
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
            ->allowedFilters([
                Filter::custom('date,title', FilterOr::class),
            ])
            ->allowedIncludes('image')
            ->translated($request->input('translatable_fields'))
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

    public function files(Object $object): Collection
    {
        return $object->files;
    }

    public function attachFiles(Object $object, Request $request): JsonResponse
    {
        return $object->attachFiles($request);
    }

    public function detachFile(Object $object, File $file): void
    {
        $object->detachFile($file);
    }
}
