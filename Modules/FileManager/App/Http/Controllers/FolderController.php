<?php

namespace Modules\FileManager\App\Http\Controllers;

use App\Helpers\Traits\QueryBuilderTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\FileManager\App\Models\Folder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class FolderController extends Controller
{
    use QueryBuilderTrait;
    public $modelClass = Folder::class;

    public function index(Request $request)
    {
        $query = $this->defaultQuery($request);
        $this->defaultAllowFilter($query, $request);
        return $this->withPagination($query, $request);
    }

    public function create(Request $request)
    {
        $request->validate($this->modelClass::rules());

        return $this->modelClass::create($request->all());
    }

    /**
     * @param Request $request
     * @param Folder $id
     * @return mixed|Folder
     */
    public function update(Request $request, $id)
    {
        $request->validate(['title' => 'string']);
        /**
         * @var $model Folder
         */
        $model = $this->modelClass::findOrFail($id);
        $model->update(['title' => $request->title]);
        return $model;
    }

    public function delete($id)
    {
        $model = $this->modelClass::findOrFail(intval($id));
        $model->delete();
        return 'deleted';
    }
}
