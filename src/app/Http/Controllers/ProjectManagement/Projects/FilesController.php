<?php

namespace App\Http\Controllers\ProjectManagement\Projects;

use App\Models\ProjectManagement\Projects\File;
use App\Http\Controllers\Controller;
use File as FileSystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Project Files Controller.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class FilesController extends Controller
{
    private $fileableTypes = [
        'projects' => 'App\Models\ProjectManagement\Projects\Project',
    ];

    public function index(Request $request, $fileableId)
    {
        $editableFile = null;
        $fileableType = $request->segment(1); // projects, jobs
        $modelName = $this->getModelName($fileableType);
        $modelShortName = $this->getModelShortName($modelName);
        $model = $modelName::findOrFail($fileableId);
        $files = $model->files;


        // dd($fileableType);
        if (in_array($request->get('action'), ['edit', 'delete']) && $request->has('id')) {
            $editableFile = File::find($request->get('id'));
        }

        return view('crm.'.$fileableType.'.files', [$modelShortName => $model, 'files' => $files, 'editableFile' => $editableFile]);
    }




    public function create(Request $request, $fileableId)
    {
        $this->validate($request, [
            'fileable_type' => 'required',
            'file'          => 'required|file|max:10000',
            'title'         => 'required|max:60',
            'description'   => 'nullable|max:255',
        ]);

        $fileableType = array_search($request->get('fileable_type'), $this->fileableTypes);

        if ($fileableType) {
            $file = $this->proccessPhotoUpload($request->except('_token'), $fileableType, $fileableId);

            if ($file->exists) {
                flash('Upload file berhasil.', 'success');
            } else {
                flash('Upload file gagal, coba kembali.', 'danger');
            }
        } else {
            flash('Upload file gagal, coba kembali.', 'danger');
        }

        return back();
    }




    public function show($fileId)
    {
        $file = File::find($fileId);

        if ($file && file_exists(storage_path('app/public/files/'.$file->filename))) {
            $extension = FileSystem::extension('public/files/'.$file->filename);

            return response()->download(storage_path('app/public/files/'.$file->filename), $file->title.'.'.$extension);
        }

        flash(__('file.not_found'), 'danger');

        if (\URL::previous() != \URL::current()) {
            return back();
        }

        return redirect()->home();
    }

    public function update(Request $request, File $file)
    {
        $file->title = $request->get('title');
        $file->description = $request->get('description');
        $file->save();

        flash(__('file.updated'), 'success');

        return redirect()->route($file->fileable_type.'.files', $file->fileable_id);
    }

    public function destroy(Request $request, File $file)
    {
        $file->delete();
        flash(__('file.deleted'), 'warning');

        return redirect()->route($file->fileable_type.'.files', $file->fileable_id);
    }

  
        private function proccessPhotoUpload($data, $fileableType, $fileableId)
        {
            $file = $data['file'];
            $fileName = $file->hashName();
    
            // Store the file in the 'public/files' disk
            $path = Storage::disk('public')->putFile('files', $file);
    
            $fileData = [
                'fileable_id' => $fileableId,
                'fileable_type' => $fileableType,
                'filename' => $fileName,
                'path' => $path, // Set the path based on the upload location
                'title' => $data['title'],
                'description' => $data['description'],
            ];
    
            \DB::beginTransaction();
    
            try {
                // Create the File model instance
                $file = File::create($fileData);
    
                \DB::commit();
    
                return $file;
            } catch (\Exception $e) {
                \DB::rollback();
    
                // Handle any exceptions or errors
                throw $e;
            }
        }
    
    

    public function getModelName($fileableType)
    {
        return isset($this->fileableTypes[$fileableType]) ? $this->fileableTypes[$fileableType] : false;
    }

    public function getModelShortName($modelName)
    {
        return strtolower((new \ReflectionClass($modelName))->getShortName());
    }
}
