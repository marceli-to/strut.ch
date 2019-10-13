<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\NavigationService;
use App\Services\MediaService;

use App\Models\Job;
use App\Models\Project;
use App\Models\Category;

use Illuminate\Http\Request;

class DownloadsController extends Controller
{
    // Services
    protected $navigationService;
    protected $menu;

    // Models
    protected $job;
    protected $project;
    protected $category;

    // View path
    protected $view_path = 'web.pages.publications';

    public function __construct(
        NavigationService $navigationService,
        Job $job,
        Project $project,
        Category $category
    )
    {
        $this->navigation = $navigationService;
        $this->menu = $this->navigation->boot();
        $this->job = $job;
        $this->project = $project;
        $this->category = $category;
    }

    public function index()
    {
        // Downloads - get all projects and group them by categories
        $projects         = $this->category->published()->with('activeTypes.activeProjects.downloads')->get();
        $grouped_projects = $projects->groupBy('name');

        // Filter out categories & types without files
        $categories = [];
        $types      = [];
        foreach($projects as $category) {
            foreach($category->activeTypes as $type) {
                foreach($type->activeProjects as $project) {
                    foreach($project->downloads as $file) {
                        if ($file)
                        {
                            $categories[$category->id] = true;
                            $types[$type->id] = true;
                        }
                    }
                }
            }   
        }

        // Jobs
        $jobs = $this->job->published()->orderBy('order', 'ASC')->get();
               
        return view(
            $this->view_path . '.downloads', 
            [
                'menu'       => $this->menu,
                'jobs'       => $jobs,
                'projects'   => $grouped_projects,
                'categories' => $categories,
                'types'      => $types
            ]
        );
    }
}
