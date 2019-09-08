<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\NavigationService;
use Illuminate\Http\Request;

class PublicationsController extends Controller
{
    protected $navigationService;

    protected $view_path = 'web.pages.publications';

    protected $menu;

    public function __construct(NavigationService $navigationService)
    {
        $this->navigation = $navigationService;
        $this->menu = $this->navigation->boot();
    }

    public function index()
    {
        $menu = $this->navigation->boot();
        return view($this->view_path . '.index', ['menu' => $this->menu]);
    }

    public function press()
    {
        $menu = $this->navigation->boot();
        return view($this->view_path . '.index', ['menu' => $this->menu]);
    }

    public function books()
    {
        $menu = $this->navigation->boot();
        return view($this->view_path . '.index', ['menu' => $this->menu]);
    }

    public function downloads()
    {
        $menu = $this->navigation->boot();
        return view($this->view_path . '.index', ['menu' => $this->menu]);
    }
}
