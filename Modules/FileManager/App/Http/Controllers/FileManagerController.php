<?php

namespace Modules\FileManager\App\Http\Controllers;

use App\Helpers\Traits\QueryBuilderTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\FileManager\App\Http\Repositories\FileRepository;
use Modules\FileManager\App\Http\Requests\StoreFileRequest;
use Modules\FileManager\App\Models\File;

class FileManagerController extends Controller
{
    use QueryBuilderTrait;
    public function __construct(
        public FileRepository $fileRepository = new FileRepository(),
    )
    {
    }

    public function index(Request $request)
    {
        return $this->fileRepository->index($request);
    }
    public function upload(StoreFileRequest $request)
    {
        return $this->fileRepository->upload($request);
    }
    public function adminUpload(StoreFileRequest $request)
    {
        return $this->fileRepository->upload($request);
    }

    public function show(Request $request, File $file)
    {
        $this->allowIncludeAndAppend($request, $file);
        return okResponse($file);
    }

    public function delete(File $file)
    {
        return $this->fileRepository->delete($file);
    }
    public function update(Request $request, File $file)
    {
        $request->validate([
            'name' => 'array',
        ]);
        $file->update($request->only([
            'name',
            'title',
            'description'
        ]));
        return okResponse($file);
    }

}
