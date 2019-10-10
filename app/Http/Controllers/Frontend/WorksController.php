<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\NavigationService;
use App\Models\Project;
use App\Models\Category;

use Illuminate\Http\Request;

class WorksController extends Controller
{
    // Services
    protected $navigationService;
    protected $menu;

    // View path
    protected $view_path = 'web.pages.works';

    // Models
    protected $project;
    protected $category;

    public function __construct(
        NavigationService $navigationService,
        Project $project,
        Category $category)
    {
        $this->navigation   = $navigationService;
        $this->menu         = $this->navigation->boot();
        $this->project      = $project;
        $this->category     = $category;
    }

    public function byStatus()
    {
        // Get all projects and group them by it's status
        $projects = $this->project->published()
                                  ->with('images')
                                  ->with('downloads')
                                  ->orderBy('status')
                                  ->get();
        $grouped_projects = $projects->groupBy('status');


        // Get all projects marked as competition
        $competition = $this->project->published()
                                     ->competition()
                                     ->with('images')
                                     ->with('downloads')
                                     ->orderBy('status')
                                     ->get();

        $grouped_competition = $competition->groupBy('competition');

        return view(
            $this->view_path . '.status', 
            [
                'menu'          => $this->menu,
                'projects'      => $grouped_projects,
                'competition'   => $grouped_competition,
                'listBy'        => 'status'
            ]
        );
    }

    public function byYear()
    {
        // Get all projects and group them by it's status
        $projects = $this->project->published()
                                  ->with('images')
                                  ->with('downloads')
                                  ->orderBy('year', 'DESC')
                                  ->get();
        $grouped_projects = $projects->groupBy('year');
        $project_columns  = \AppHelper::partition($grouped_projects, 'year');

        return view(
            $this->view_path . '.year', 
            [
                'menu'          => $this->menu,
                'projects'      => $project_columns,
                'listBy'        => 'year'
            ]
        );
    }

    public function byType()
    {
        // Get all projects and group them by categories
        $projects = $this->category->published()->with('activeTypes.activeProjects')->get();
        $grouped_projects = $projects->groupBy('name');

        return view(
            $this->view_path . '.type', 
            [
                'menu'          => $this->menu,
                'projects'      => $grouped_projects,
                'listBy'        => 'type'
            ]
        );
    }
}
