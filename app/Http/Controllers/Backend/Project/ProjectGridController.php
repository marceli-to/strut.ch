<?php

namespace App\Http\Controllers\Backend\Project;

use App\Services\MediaService;
use App\Models\ProjectImage;
use App\Models\ProjectGrid;
use App\Models\ProjectGridElement;
use App\Http\Resources\ProjectGridCollection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectGridController extends Controller
{
    protected $mediaService;

    protected $projectGrid;

    protected $projectGridElement;

    protected $projectImage;

    public function __construct(
        MediaService $service,
        ProjectGrid $projectGrid, 
        ProjectGridElement $projectGridElement,
        ProjectImage $projectImage
    )
    {
        $this->mediaService = $service;
        $this->projectGrid = $projectGrid;
        $this->projectGridElement = $projectGridElement;
        $this->projectImage = $projectImage;
    }
    
    /**
     * Get all grids by project
     *
     * @param int $projectId
     * @return \Illuminate\Http\Response
     */
    public function get($projectId)
    {
        return $this->_fetch($projectId);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param int $projectId
     * @param int $layoutId
     * @return \Illuminate\Http\Response
     */
    public function store($projectId, $layoutId)
    {
        $grid = new ProjectGrid([
            'project_id' => $projectId,
            'layout_id'  => $layoutId,
            'order'      => -1,
            'publish'    => 1,
        ]);

        $grid->save();
        return $this->_fetch($projectId);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Mark images as unused
        $images = $this->projectGridElement->where('grid_id', '=', $id)->get();
        foreach($images as $i)
        {
            $img = $this->projectImage->find($i->project_image_id);
            $img->is_grid = 0;
            $img->save();
        }
        
        $this->projectGrid->find($id)->delete();
        $this->projectGridElement->where('grid_id', '=', $id)->delete();
        return response()->json('successfully deleted');
    }

    /**
     * Fetch database records by project
     *
     * @param int $project_id
     */

    protected function _fetch($projectId)
    {
        $projectGrids = $this->projectGrid
            ->byProject($projectId)
            ->with('layout')
            ->orderBy('order', 'ASC')
            ->get();
        return new ProjectGridCollection($projectGrids);
    }
}
