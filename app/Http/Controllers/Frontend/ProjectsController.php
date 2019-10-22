<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\NavigationService;
use App\Services\MediaService;
use App\Models\Project;
use App\Models\ProjectFile;
use App\Models\ProjectImage;
use App\Models\ProjectGrid;
use App\Models\Category;


use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    // Services
    protected $navigationService;
    protected $mediaService;

    // Models
    protected $project;
    protected $projectFile;
    protected $projectImage;
    protected $projectGrid;
    protected $category;

    // View path
    protected $view_path = 'web.pages.projects';

    protected $menu;

    public function __construct(
        NavigationService $navigationService,
        MediaService $mediaService,
        Project $project,
        ProjectFile $projectFile,
        ProjectImage $projectImage,
        ProjectGrid $projectGrid,
        Category $category
    )
    {
        $this->navigation   = $navigationService;
        $this->menu         = $this->navigation->boot();
        $this->project      = $project;
        $this->projectFile  = $projectFile;
        $this->projectImage = $projectImage;
        $this->projectGrid  = $projectGrid;
        $this->category     = $category;
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
        // Project
        $project = $this->project->published()
                                 ->with('category')
                                 ->with('categoryType')
                                 ->with('downloads')
                                 ->findOrFail($id);
        
        // Menu
        $this->menu = $this->navigation->boot(
            $project->id,
            $project->category->id,
            $project->categoryType->id
        );

        // Open graph image (first active image)
        $og_image = $this->projectImage->where('project_id', '=', $id)
                                       ->where('publish', '=', 1)
                                       ->get()
                                       ->first();

        return view(
            $this->view_path . '.project',
            [
                'menu'     => $this->menu,
                'project'  => $project,
                'og_image' => $og_image ? $og_image->name : null,
                'browse'   => $this->getProjectNav($id),
                'grids'    => $this->getProjectGrid($id)
            ]
        );
    }

    /**
     * Show a preview
     * 
     * @param int $id
     * @param int $slug
     */
    public function preview($id = NULL, $slug = NULL)
    {
        // Project
        $project = $this->project->with('category')
                                 ->with('categoryType')
                                 ->with('downloads')
                                 ->findOrFail($id);
        
        // Menu
        $this->menu = $this->navigation->boot(
            $project->id,
            $project->category->id,
            $project->categoryType->id
        );

        // Open graph image (first active image)
        $og_image = $this->projectImage->where('project_id', '=', $id)
                                       ->where('publish', '=', 1)
                                       ->get()
                                       ->first();

        return view(
            $this->view_path . '.preview',
            [
                'menu'     => $this->menu,
                'project'  => $project,
                'og_image' => $og_image ? $og_image->name : null,
                'browse'   => $this->getProjectNav($id),
                'grids'    => $this->getProjectGrid($id)
            ]
        );
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

    protected function getProjectNav($id = NULL)
    {
        // Build project nav
        $projects     = $this->category->published()->with('activeTypes.activeProjectsWithDetail')->get();
        $project_keys = [];
        
        foreach($projects as $category)
        {
            foreach($category->activeTypes as $type)
            {
                foreach($type->activeProjectsWithDetail as $p)
                {
                    $project_keys[] = (int) $p->id;
                }
            }
        }

        // Get current key
        $key = array_search ($id, $project_keys);

        if ($key == 0)
        {
            $prevId = end($project_keys);
            $nextId = $project_keys[$key+1];
        }
        else if ($key == count($project_keys) - 1)
        {
            $prevId = $project_keys[$key-1];
            $nextId = $project_keys[0];
        }
        else
        {
            $prevId = $project_keys[$key-1];
            $nextId = $project_keys[$key+1];
        }

        $project_nav = [
            'prev' => $this->project->with('activeImages')->find($prevId),
            'next' => $this->project->with('activeImages')->find($nextId),
        ];

        return $project_nav;
    }
}
