<?php

namespace TypiCMS\Modules\Objects\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Files\Models\File;
use TypiCMS\Modules\Objects\Models\Object;
use TypiCMS\Modules\Objects\Repositories\EloquentObject;

class ApiController extends BaseApiController
{
    public function __construct(EloquentObject $object)
    {
        parent::__construct($object);
    }

    public function index(Request $request)
    {
        $data = QueryBuilder::for(Object::class)
            ->allowedFilters('date')
            ->translated($request->input('translatable_fields'))
            ->with('files')
            ->paginate($request->input('per_page'));

        return $data;
    }

    protected function updatePartial(Object $object, Request $request)
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

        $this->repository->forgetCache();
    }

    public function destroy(Object $object)
    {
        $deleted = $this->repository->delete($object);

        return response()->json([
            'error' => !$deleted,
        ]);
    }

    public function files(Object $object)
    {
        return $object->files;
    }

    public function attachFiles(Object $object, Request $request)
    {
        return $this->repository->attachFiles($object, $request);
    }

    public function detachFile(Object $object, File $file)
    {
        return $this->repository->detachFile($object, $file);
    }
}
