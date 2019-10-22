<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\NavigationService;
use Illuminate\Http\Request;

class ErrorController extends Controller
{
    // Services
    protected $navigationService;
    protected $menu;
   
    // View path
    protected $view_path = 'web.errors';

    public function __construct(NavigationService $navigationService)
    {
        $this->navigation = $navigationService;
        $this->menu = $this->navigation->boot();
    }

    public function notfound()
    {
        return view($this->view_path . '.404', ['menu' => $this->menu]);
    }

    public function fatal()
    {
        return view($this->view_path . '.500', ['menu' => $this->menu]);
    }
}