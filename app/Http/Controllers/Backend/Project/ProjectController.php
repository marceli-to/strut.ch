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
     * Get one record
     *
     * @param id $projectId
     * @return \Illuminate\Http\Response
     */

    public function get($projectId)
    {
        $project = $this->project->find($projectId);
        return response()->json($project);
    }

    /**
     * Get all records
     *
     * @return \Illuminate\Http\Response
     */

    public function all()
    {
        $projects = $this->project->orderBy('order', 'ASC')
                                  ->orderBy('year', 'ASC')
                                  ->with('images')
                                  ->with('category', 'categoryType')
                                  ->get();
        return new ProjectCollection($projects);
    }

    /**
     * Get all records with constraints
     *
     * @return \Illuminate\Http\Response
     */

    public function fetch($publish = 0, $order = 'ASC')
    {
        $projects = $this->project->where('publish', '=', $publish)
                                  ->orderBy('year', 'DESC')
                                  //->orderBy('name->de', $order)
                                  ->with('images')
                                  ->get();

                                  
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
            'title'             => ['de' => $request->input('title.de')],
            'name'              => ['de' => $request->input('name.de')],
            'location'          => ['de' => $request->input('location.de')],
            'description'       => ['de' => $request->input('description.de')],
            'info'              => ['de' => $request->input('info.de')],        
            'year'              => $request->input('year'),
            'has_detail'        => $request->input('has_detail'),
            'status'            => $request->input('status'),
            'competition'       => $request->input('competition'),
            'publish'           => $request->input('publish'),
            'category_id'       => $request->input('category_id'),
            'category_type_id'  => $request->input('category_type_id'),
        ]);

        $project->save();

        if (!empty($request->images))
        {
            foreach($request->images as $i)
            {
                $image = new ProjectImage([
                    'project_id'        => $project->id,
                    'name'              => $i['name'],
                    'caption'           => ['de' => $i['caption']['de']],
                    'publish'           => 1,
                    'is_preview_type'   => $i['is_preview_type'] ? $i['is_preview_type'] : 0,
                    'is_preview_status' => $i['is_preview_status'] ? $i['is_preview_status'] : 0,
                    'is_preview_year'   => $i['is_preview_year'] ? $i['is_preview_year'] : 0
                ]);
                $image->save();
            }
        }

        if (!empty($request->downloads))
        {
            foreach($request->downloads as $f)
            {
                $file = new ProjectFile([
                    'project_id'        => $project->id,
                    'name'              => $f['name'],
                    'caption'           => ['de' => $f['caption']['de']],
                    'publish'           => $f['publish'] ? $f['publish'] : 0,
                ]);
                $file->save();
            }
        }

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
        $project = $this->project->with('images')->with('downloads')->findOrFail($id);
        return response()->json($project);
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
        $project = $this->project->findOrFail($id);

        $project->setTranslation('title', 'de', $request->input('title.de'));
        $project->setTranslation('name', 'de', $request->input('name.de'));
        $project->setTranslation('location', 'de', $request->input('location.de'));
        $project->setTranslation('description', 'de', $request->input('description.de'));
        $project->setTranslation('info', 'de', $request->input('info.de'));
        $project->year              = $request->input('year');
        $project->has_detail        = $request->input('has_detail');
        $project->status            = $request->input('status');
        $project->competition       = $request->input('competition');
        $project->publish           = $request->input('publish');
        $project->category_id       = $request->input('category_id');
        $project->category_type_id  = $request->input('category_type_id');
        $project->save();

        if (!empty($request->images))
        {
            foreach($request->images as $i)
            {
                $image = ProjectImage::updateOrCreate(
                    ['id' => $i['id']], 
                    [
                        'project_id'        => $project->id,
                        'name'              => $i['name'],
                        'caption'           => ['de' => $i['caption']['de']],
                        'publish'           => $i['publish'] ? $i['publish'] : 0,
                        'is_preview_type'   => $i['is_preview_type'] ? $i['is_preview_type'] : 0,
                        'is_preview_status' => $i['is_preview_status'] ? $i['is_preview_status'] : 0,
                        'is_preview_year'   => $i['is_preview_year'] ? $i['is_preview_year'] : 0
                    ]
                );
            }
        }

        if (!empty($request->downloads))
        {
            foreach($request->downloads as $f)
            {
                $file = ProjectFile::updateOrCreate(
                    ['id' => $f['id']], 
                    [
                        'project_id'        => $project->id,
                        'name'              => $f['name'],
                        'caption'           => ['de' => $f['caption']['de']],
                        'publish'           => $f['publish'] ? $f['publish'] : 0,
                    ]
                );
            }
        }

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
        $project = $this->project->findOrFail($id);
        $projectCopy = $project->replicate();
        $projectCopy->setTranslation('name', 'de', $project->getTranslation('name', 'de') . ' (Kopie)');
        $projectCopy->publish = 0;
        $projectCopy->save();

        $projectCopy->save();
        return response()->json($projectCopy);
    }

    /**
     * Update the status of the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status($id)
    {
        $project = $this->project->findOrFail($id);
        $project->publish = $project->publish == 0 ? 1 : 0;
        $project->save();
        return response()->json($project->publish);
    }

    /**
     * Update the order of the resources.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function order(Request $request)
    {
        $projects = $request->get('projects');

        foreach($projects as $project)
        {
            $p = $this->project->find($project['id']);
            $p->order = $project['order'];
            $p->save(); 
        }
        return response()->json('successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = $this->project->with('images')->find($id);
        
        // Delete assets (files, images)
        if (isset($project->images))
        {
            foreach($project->images as $i)
            {
                $this->mediaService->delete($i->name);
                $i->delete();
            }
        }

        if (isset($project->downloads))
        {
            foreach($project->downloads as $f)
            {
                $this->mediaService->delete($f->name);
                $f->delete();
            }
        }

        $project->delete();
        $projects = $this->project->get();
        return new ProjectCollection($projects);
    }
}
