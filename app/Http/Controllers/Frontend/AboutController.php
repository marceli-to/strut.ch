<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\NavigationService;
use App\Services\MediaService;
use App\Models\Job;
use App\Models\Team;
use App\Models\Award;
use App\Models\Lecture;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    // Services
    protected $navigationService;
    protected $mediaService;
    protected $menu;
    
    // Models
    protected $job;
    protected $team;
    protected $award;
    protected $lecture;

    // View path
    protected $view_path = 'web.pages.about';

    public function __construct(
        NavigationService $navigationService,
        MediaService $mediaService,
        Job $job,
        Team $team,
        Award $award,
        Lecture $lecture
    )
    {
        $this->navigation = $navigationService;
        $this->menu = $this->navigation->boot();
        $this->mediaServices = $mediaService;
        $this->job = $job;
        $this->team = $team;
        $this->award = $award;
        $this->lecture = $lecture;
    }

    public function about()
    {
        $team = $this->team->orderBy('order', 'ASC')->get();
        return view($this->view_path . '.index', ['menu' => $this->menu, 'team' => $team]);
    }

    public function jobs()
    {
        $jobs = $this->job->orderBy('order', 'ASC')->get();
        return view($this->view_path . '.jobs', ['menu' => $this->menu, 'jobs' => $jobs]);
    }

    public function awards()
    {
        $awards = $this->award->orderBy('year', 'DESC')->get();
        return view($this->view_path . '.awards', ['menu' => $this->menu, 'awards' => $awards]);
    }

    public function lectures()
    {
        $lectures = $this->lecture->orderBy('year', 'DESC')->get();
        return view($this->view_path . '.lectures', ['menu' => $this->menu, 'lectures' => $lectures]);
    }
}