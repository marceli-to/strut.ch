<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\NavigationService;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    protected $navigationService;

    protected $view_path = 'web.pages.about';

    protected $menu;

    public function __construct(NavigationService $navigationService)
    {
        $this->navigation = $navigationService;
        $this->menu = $this->navigation->boot();
    }

    public function about()
    {
        return view($this->view_path . '.index', ['menu' => $this->menu]);
    }

    public function jobs()
    {
        return view($this->view_path . '.index', ['menu' => $this->menu]);
    }

    public function awards()
    {
        return view($this->view_path . '.index', ['menu' => $this->menu]);
    }

    public function lectures()
    {
        return view($this->view_path . '.index', ['menu' => $this->menu]);
    }
}