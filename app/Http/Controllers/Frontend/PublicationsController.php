<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\NavigationService;
use App\Services\MediaService;
use App\Models\Press;
use App\Models\Book;

use Illuminate\Http\Request;

class PublicationsController extends Controller
{
    // Services
    protected $navigationService;
    protected $mediaService;
    protected $menu;

    // Models
    protected $press;
    protected $book;

    protected $view_path = 'web.pages.publications';

    public function __construct(
        NavigationService $navigationService,
        Press $press,
        Book $book
    )
    {
        $this->navigation = $navigationService;
        $this->menu = $this->navigation->boot();
        $this->book = $book;
        $this->press = $press;
    }

    public function index()
    {
        return view($this->view_path . '.index', ['menu' => $this->menu]);
    }

    public function press()
    {
        $press = $this->press->orderBy('year', 'DESC')->get();
        return view($this->view_path . '.press', ['menu' => $this->menu, 'press' => $press]);
    }

    public function books()
    {
        $books = $this->book->get();
        return view($this->view_path . '.books', ['menu' => $this->menu, 'books' => $books]);
    }

    public function downloads()
    {
        return view($this->view_path . '.downloads', ['menu' => $this->menu]);
    }
}
