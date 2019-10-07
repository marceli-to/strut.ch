<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\NavigationService;

use App\Services\MediaService;
use App\Models\Project;
use App\Models\HomeGrid;
use App\Models\HomeGridElement;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Services
    protected $navigationService;
    protected $mediaService;

    // Models
    protected $project;
    protected $homeGrid;

    // View path
    protected $view_path = 'web.pages.home';

    protected $menu;
    
    public function __construct(
        NavigationService $navigationService,
        MediaService $mediaService,
        Project $project,
        HomeGrid $homeGrid,
        HomeGridElement $homeGridElement
    )
    {
        $this->navigation       = $navigationService;
        $this->menu             = $this->navigation->boot();
        $this->project          = $project;
        $this->homeGrid         = $homeGrid;
        $this->homeGridElement  = $homeGridElement;
    }

    public function index()
    {
        return view(
            $this->view_path . '.index', 
            [
                'menu'       => $this->menu,
                'highlight'  => $this->getHighlight(),
                'grids'      => $this->getGrids()
            ]
        );
    }

    /**
     * Return grids
     */

    private function getGrids()
    {
        $grids = $this->homeGrid->with('layout')
                                ->with('elements.projectimage.project')
                                ->with('elements.news')
                                ->orderBy('order')
                                ->get();
        $home_grids = [];
        foreach($grids as $g)
        {
            $home_grids[$g->id]['key'] = $g->layout->key;
    
            // Filter by environment & sort by position
            $sorted = $g->elements->where('environment', 'production')->sortBy('position');
            $home_grids[$g->id]['elements'] = $sorted->values()->all();
        }
        
        return $home_grids;
    }

    /**
     * Return highlight section images
     */

    private function getHighlight()
    {
        // Get highlights
        $highlights = $this->homeGridElement->highlight()
                                            ->isProduction()
                                            ->with('projectimage.project')
                                            ->get();
        if ($highlights->isEmpty())
        {
            return NULL;
        }

        // Shuffle highlights and pick one
        $random_item   = $highlights->shuffle()->first();

        // Create project & slug
        $project_image = $random_item->projectimage->name;
        $project       = $random_item->projectimage->project;

        $project_slug  = $project->id .'/'.
            str_slug(
                \AppHelper::transliterate($project->getTranslation('name', 'de')) . '-' .
                \AppHelper::transliterate($project->getTranslation('location', 'de')) . '-' .
                $project->year
            , '-')
        ;

        $highlight = [
            'image' => $project_image,
            'title' => $project->name . ', ' . $project->location . ' ' . $project->year,
            'slug'  => $project_slug,
        ];

        return $highlight;
    }
}
