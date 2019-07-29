<?php

namespace App\Http\Controllers\Backend\Grid;

use App\Services\MediaService;
use App\Grid;
use App\GridElement;
use App\Http\Resources\GridCollection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GridController extends Controller
{
    protected $mediaService;

    protected $grid;

    protected $grid_element;

    public function __construct(MediaService $service, Grid $grid, GridElement $grid_element)
    {
        $this->mediaService = $service;
        $this->grid = $grid;
        $this->grid_element = $grid_element;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return 
            new GridCollection(
                    $this->grid->with('layout')
                               ->orderBy('position', 'ASC')
                               ->get()

            );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store($layoutId)
    {
        $row = new Grid([
            'grid_layout_id' => $layoutId,
            'position'       => 999,
        ]);
        $row->save();

        return new GridCollection($this->grid->with('layout')->orderBy('position', 'ASC')->get());

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->grid->find($id)->delete();
        $this->grid_element->where('grid_id', '=', $id)->delete();
        return response()->json('successfully deleted');
    }
}
