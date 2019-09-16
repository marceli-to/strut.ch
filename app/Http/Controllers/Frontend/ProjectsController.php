<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\NavigationService;
use App\Services\MediaService;
use App\Models\Project;
use App\Models\ProjectFile;
use App\Models\ProjectImage;

use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    protected $navigationService;
    
    protected $mediaService;

    protected $project;

    protected $projectFile;
    
    protected $projectImage;
    
    protected $view_path = 'web.pages.projects';

    protected $menu;

    public function __construct(
        NavigationService $navigationService,
        MediaService $mediaService,
        Project $project,
        ProjectFile $projectFile,
        ProjectImage $projectImage
    )
    {
        $this->navigation   = $navigationService;
        $this->menu         = $this->navigation->boot();
        $this->project      = $project;
        $this->projectFile  = $projectFile;
        $this->projectImage = $projectImage;
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
        $project = $this->project->with('category')
                                 ->with('categoryType')
                                 ->with('images')
                                 ->with('downloads')
                                 ->findOrFail($id);
        return view($this->view_path . '.project', ['menu' => $this->menu, 'project' => $project]);
    }

    /**
     * Show a preview
     * 
     * @param Project $project
     */
    public function preview(Project $project)
    {
        return view(
            $this->view_path . '.project',
            [
                'menu' => $this->menu, 
                'project' => $project,
                'is_preview' => TRUE
            ]);
    }
}
