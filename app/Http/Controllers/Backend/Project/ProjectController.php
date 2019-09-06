<?php
namespace App\Http\Controllers\Backend\Project;

use App\Services\MediaService;
use App\Models\Project;
use App\Models\ProjectFile;
use App\Models\ProjectImage;
use App\Http\Resources\ProjectCollection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $mediaService;

    protected $project;

    protected $projectFile;
    
    protected $projectImage;
    
    /**
     * Constructor
     * 
     * @param MediaService $mediaService
     * @param Project $project
     */

    public function __construct(
        MediaService $mediaService,
        Project $project,
        ProjectFile $projectFile,
        ProjectImage $projectImage
    )
    {
        $this->mediaService = $mediaService;
        $this->project      = $project;
        $this->projectFile  = $projectFile;
        $this->projectImage = $projectImage;
    }

    /**
     * Get all records
     *
     * @return \Illuminate\Http\Response
     */

    public function get()
    {
        $projects = $this->project->get();
        return new ProjectCollection($projects);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {   
        $project = new Project([
            'title' => [
                'de' => $request->input('title.de'),
                'en' => $request->input('title.en'),
            ],
            'description' => [
                'de' => $request->input('description.de'),
                'en' => $request->input('description.en'),
            ],
            'year' => $request->input('year'),          
            'media' => $request->input('media'),          
        ]);

        $project->save();
        return response()->json(['projectId' => $project->id]);
    }

    /**
     * Edit a specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $award = $this->project->findOrFail($id);
        return response()->json($award);
    }

    /**
     * Update the status of the specified resource.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $award = $this->project->findOrFail($id);
        $project->setTranslation('title', 'de', $request->input('title.de'));
        $project->setTranslation('description', 'de', $request->input('description.de'));
        $project->year = $request->input('year') ? $request->input('year') : NULL;
        $project->media = $request->input('media') ? $request->input('media') : NULL;
        $project->save();
        return response()->json('successfully updated');
    }

    /**
     * Clone a specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function clone($id)
    {
        $award = $this->project->findOrFail($id);
        $awardCopy = $project->replicate();
        $awardCopy->setTranslation('title', 'de', $project->getTranslation('title', 'de') . ' (Kopie)');
        $awardCopy->media = null;
        $awardCopy->publish = 0;
        $awardCopy->save();
        $projects = $this->project->orderBy('year', 'DESC')->get()->groupBy('year');
        return new ProjectCollection($projects);
    }

    /**
     * Update the status of the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status($id)
    {
        $award = $this->project->findOrFail($id);
        $project->publish = $project->publish == 0 ? 1 : 0;
        $project->save();
        return response()->json($project->publish);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $award = $this->project->find($id);

        if ($project->media)
        {
            $this->mediaService->delete($project->media);
        }
        $project->delete();
        $projects = $this->project->orderBy('year', 'DESC')->get()->groupBy('year');
        return new ProjectCollection($projects);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  str $filename
     * @return \Illuminate\Http\Response
     */
    public function unlink($filename)
    {
        $award = $this->project->where('media', $filename)->first();
        if ($award)
        {
            $project->media = null;
            $project->save();
        }
        $this->mediaService->delete($filename);
        return response()->json('successfully deleted');
    }
}
