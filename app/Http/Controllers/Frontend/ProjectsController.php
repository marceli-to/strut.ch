<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\NavigationService;
use App\Services\MediaService;
use App\Models\Project;
use App\Models\ProjectFile;
use App\Models\ProjectImage;

use App\Models\ProjectGrid;

use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    protected $navigationService;
    protected $mediaService;
    protected $project;
    protected $projectFile;
    protected $projectImage;
    protected $projectGrid;

    protected $view_path = 'web.pages.projects';

    protected $menu;

    public function __construct(
        NavigationService $navigationService,
        MediaService $mediaService,
        Project $project,
        ProjectFile $projectFile,
        ProjectImage $projectImage,
        ProjectGrid $projectGrid
    )
    {
        $this->navigation   = $navigationService;
        $this->menu         = $this->navigation->boot();
        $this->project      = $project;
        $this->projectFile  = $projectFile;
        $this->projectImage = $projectImage;
        $this->projectGrid  = $projectGrid;
    }

    /**
     * List all projects
     * 
     */
    public function projects()
    {
        return view($this->view_path . '.index', ['menu' => $this->menu]);
    }

    /**
     * Show a resource
     * 
     * @param int $id
     * @param int $slug
     */
    public function project($id = NULL, $slug = NULL)
    {
        $project = $this->project->published()
                                 ->with('category')
                                 ->with('categoryType')
                                 ->with('downloads')
                                 ->findOrFail($id);

        $this->menu = $this->navigation->boot(
            $project->id,
            $project->category->id,
            $project->categoryType->id
        );

        return view(
            $this->view_path . '.project',
            [
                'menu'    => $this->menu,
                'project' => $project,
                'grids'   => $this->getProjectGrid($id)
            ]
        );
    }

    /**
     * Show a preview
     * 
     * @param Project $project
     */
    public function preview(Project $project)
    {
        return view(
            $this->view_path . '.preview',
            [
                'menu'          => $this->menu, 
                'project'       => $project,
                'grids'         => $this->getProjectGrid($project->id),
                'is_preview'    => TRUE
            ]);
    }

    protected function getProjectGrid($projectId)
    {
        $grids = $this->projectGrid->byProject($projectId)
                                   ->with('layout')
                                   ->with('elements.image')
                                   ->orderBy('order')
                                   ->get();

        $project_grids = [];
        foreach($grids as $g)
        {
            $project_grids[$g->id]['key'] = $g->layout->key;

            // Sort elements by position
            $sorted = $g->elements->sortBy('position');
            $project_grids[$g->id]['elements'] = $sorted->values()->all();
        }

        return $project_grids;
    }
}
