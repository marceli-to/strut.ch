<?php
namespace App\Http\Controllers\Backend\Grid;

use App\Http\Controllers\Controller;
use App\GridLayout;
use App\Http\Resources\GridCollection;

use Illuminate\Http\Request;

class GridLayoutController extends Controller
{
    protected $gridLayout;

    public function __construct(GridLayout $gridLayout)
    {
        $this->gridLayout = $gridLayout;
    }

    /**
     * Fetch all layouts
     *
     * @return \Illuminate\Http\Response
     */
    public function fetch()
    {
        return new GridCollection($this->gridLayout->isHome()->get());
    }
}
