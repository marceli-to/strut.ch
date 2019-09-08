<?php
namespace App\Http\Controllers\Backend\Project;

use App\Services\MediaService;
use App\Models\Project;
use App\Models\ProjectFile;
use App\Http\Resources\ProjectFileCollection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectFileController extends Controller
{
    protected $mediaService;

    protected $project;
    
    protected $projectFile;

    /**
     * Constructor
     * 
     * @param MediaService $mediaService
     * @param Project $project
     */

    public function __construct(
        MediaService $mediaService,
        Project $project,
        ProjectFile $projectFile
    )
    {
        $this->mediaService = $mediaService;
        $this->project      = $project;
        $this->projectFile  = $projectFile;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  str $filename
     * @return \Illuminate\Http\Response
     */
    public function unlink($filename)
    {
        $file = $this->projectFile->where('name', $filename)->first();
        if ($file)
        {
            $file->delete();
        }
        $this->mediaService->delete($filename);
        return response()->json('successfully deleted');
    }

    /**
     * Update the status of the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status($id)
    {
        $file = $this->projectFile->findOrFail($id);
        $file->publish = $file->publish == 0 ? 1 : 0;
        $file->save();
        return response()->json($file->publish);
    }
}
