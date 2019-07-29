<?php

namespace App\Http\Controllers\Backend\Grid;

use App\GridElement;
use App\Http\Resources\GridCollection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GridElementController extends Controller
{
    protected $grid_element;

    public function __construct(GridElement $grid_element)
    {
        $this->grid_element = $grid_element;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $grid_element = new GridElement([
            'grid_id'       => $request->get('grid_id'),
            'post_media_id' => $request->get('post_media_id'),
            'position'      => $request->get('position')
        ]);

        $grid_element->save();
        return response()->json('success');
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
        $this->grid_element->find($id)->delete();
        return response()->json('successfully deleted');
    }
}
