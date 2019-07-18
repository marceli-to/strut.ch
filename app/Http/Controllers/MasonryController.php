<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MediaService;
use App\Http\Resources\MasonryCollection;
use App\MasonryLayout;
use App\MasonryRow;
use App\MasonryElement;

class MasonryController extends Controller
{
    protected $mediaService;

    protected $masonryRow;

    protected $masonryElement;

    protected $masonryLayout;


    public function __construct(
        MediaService $service, 
        MasonryRow $masonryRow,
        MasonryElement $masonryElement,
        MasonryLayout $masonryLayout)
    {
        $this->mediaService     = $service;
        $this->masonryRow       = $masonryRow;
        $this->masonryElement   = $masonryElement;
        $this->masonryLayout    = $masonryLayout;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return 
            new MasonryCollection(
                $this->masonryRow->with('layout')
                                 ->with('elements')
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    // Add a row
    public function addRow($layoutId)
    {
        $row = new MasonryRow([
            'masonry_layout_id' => $layoutId,
            'position'          => 999,
        ]);
        $row->save();

        return new MasonryCollection($this->masonryRow->with('layout')->orderBy('position', 'ASC')->get());
    }

    // Delete a row
    public function deleteRow($id)
    {
        $this->masonryRow->find($id)->delete();
        return response()->json('successfully deleted');
    }
}
