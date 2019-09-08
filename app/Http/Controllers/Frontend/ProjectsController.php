<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\NavigationService;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    protected $navigationService;

    protected $view_path = 'web.pages.projects';

    protected $menu;

    public function __construct(NavigationService $navigationService)
    {
        $this->navigation = $navigationService;
        $this->menu = $this->navigation->boot();
    }

    public function projects()
    {
        $menu = $this->navigation->boot();
        return view($this->view_path . '.project', ['menu' => $this->menu]);
    }
}
