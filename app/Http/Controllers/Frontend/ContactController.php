<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\NavigationService;
use App\Services\MediaService;
use App\Models\Content;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Services
    protected $navigationService;
    protected $mediaService;
    protected $menu;

    // Models
    protected $content;

    // Static content key
    protected $key_contact = 'contact';
    protected $key_imprint = 'imprint';

    // View path
    protected $view_path = 'web.pages.contact';
    
    public function __construct(
        NavigationService $navigationService,
        MediaService $mediaService,
        Content $content
    )
    {
        $this->navigation = $navigationService;
        $this->menu = $this->navigation->boot();
        $this->mediaServices = $mediaService;
        $this->content = $content;
    }

    public function index()
    {
        // Get content data
        $contact = $this->content->published()
                                 ->where('key', '=', $this->key_contact)
                                 ->get()
                                 ->first();

        $imprint = $this->content->published()
                                 ->where('key', '=', $this->key_imprint)
                                 ->get()
                                 ->first();

        return view(
            $this->view_path . '.index', 
            [
                'menu'    => $this->menu,
                'imprint' => $imprint,
                'contact' => $contact
            ]
    );
    }
}
