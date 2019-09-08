<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Services\NavigationService;
use Illuminate\Http\Request;

class PageController extends Controller
{
    protected $navigationService;

    public function __construct(NavigationService $navigationService)
    {
        $this->navigation = $navigationService;
    }

    public function projects()
    {
        $menu = $this->navigation->boot();


        return view('web.pages.projects.project', ['menu' => $menu]);
    }
}
