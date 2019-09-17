<?php
namespace App\Http\Controllers\Backend\Home;

use App\Models\HomeGridElement;
use App\Http\Resources\HomeGridCollection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeGridElementController extends Controller
{
    protected $homeGridElement;

    public function __construct(HomeGridElement $homeGridElement)
    {
        $this->homeGridElement = $homeGridElement;
    }

    /**
     * Get all records
     *
     * @param int $gridId
     * @return \Illuminate\Http\Response
     */

    public function get($gridId)
    {
        return new HomeGridCollection(
                $this->homeGridElement->with('projectimage.project')
                                      ->with('news')
                                      ->where('grid_id', '=', $gridId)
                                      ->get()
                );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $gridElement = new HomeGridElement([
            'grid_id'           => $request->get('grid_id'),
            'project_image_id'  => $request->get('project_image_id'),
            'news_id'           => $request->get('news_id'),
            'position'          => $request->get('position')
        ]);

        $gridElement->save();
        return response()->json('success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->homeGridElement->find($id)->delete();
        return response()->json('successfully deleted');
    }
}
