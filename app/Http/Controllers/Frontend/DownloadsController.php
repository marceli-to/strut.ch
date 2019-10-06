<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\NavigationService;
use App\Services\MediaService;

use App\Models\Job;

use Illuminate\Http\Request;

class DownloadsController extends Controller
{
    // Services
    protected $navigationService;
    protected $menu;

    // Models
    protected $job;

    // View path
    protected $view_path = 'web.pages.publications';

    public function __construct(
        NavigationService $navigationService,
        Job $job
    )
    {
        $this->navigation = $navigationService;
        $this->menu = $this->navigation->boot();
        $this->job = $job;
    }

    public function index()
    {
        $jobs = $this->job->published()->orderBy('order', 'ASC')->get();
        return view(
            $this->view_path . '.downloads', 
            [
                'menu' => $this->menu,
                'jobs' => $jobs,
            ]
        );
    }
}
