<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\NavigationService;
use App\Services\MediaService;
use App\Models\Job;
use App\Models\Team;
use App\Models\Award;
use App\Models\Lecture;
use App\Models\Content;
use App\Models\ContentImage;
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
    protected $content;
    protected $contentImage;

    // Static content key
    protected $key = 'about';

    // View path
    protected $view_path = 'web.pages.about';

    public function __construct(
        NavigationService $navigationService,
        MediaService $mediaService,
        Job $job,
        Team $team,
        Award $award,
        Lecture $lecture,
        Content $content,
        ContentImage $contentImage
    )
    {
        $this->navigation = $navigationService;
        $this->menu = $this->navigation->boot();
        $this->mediaServices = $mediaService;
        $this->job = $job;
        $this->team = $team;
        $this->award = $award;
        $this->lecture = $lecture;
        $this->content = $content;
        $this->contentImage = $contentImage;
    }

    public function about()
    {
        // Get content data
        $content = $this->content->published()
                                 ->with('images')
                                 ->where('key', '=', 'about')
                                 ->get()
                                 ->first();
        // Get team data
        $team = $this->team->published()->orderBy('order', 'ASC')->get();
        
        return view(
                $this->view_path . '.about', 
                [
                    'menu' => $this->menu,
                    'team' => $team,
                    'content' => $content
                ]
        );
    }

    public function jobs()
    {
        // Get content data
        $content = $this->content->published()
                                 ->with('images')
                                 ->where('key', '=', 'jobs')
                                 ->get()
                                 ->first();        
        // Get jobs data
        $jobs = $this->job->published()->orderBy('order', 'ASC')->get();

        return view(
            $this->view_path . '.jobs', 
            [
                'menu' => $this->menu,
                'jobs' => $jobs,
                'content' => $content
            ]
        );
    }

    public function awards()
    {
        $awards  = $this->award->published()->orderBy('year', 'DESC')->get();
        $grouped_awards = $awards->groupBy('year');
         return view(
            $this->view_path . '.awards', 
            [
                'menu' => $this->menu,
                'awards' => \AppHelper::partition($grouped_awards, 'year'),
            ]
        );
    }

    public function lectures()
    {
        $lectures = $this->lecture->published()->orderBy('year', 'DESC')->get();
        $grouped_lectures = $lectures->groupBy('year');

        return view(
            $this->view_path . '.lectures', 
            [
                'menu' => $this->menu,
                'lectures' => \AppHelper::partition($grouped_lectures, 'year'),
            ]
        );
    }
}