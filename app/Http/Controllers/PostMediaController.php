<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MediaService;
use App\PostMedia;


class PostMediaController extends Controller
{
    protected $mediaService;

    protected $postMedia;

    public function __construct(MediaService $service, PostMedia $postMedia)
    {
        $this->mediaService = $service;
        $this->postMedia    = $postMedia;
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
     * Remove the specified resource from model and storage.
     *
     * @param  str $filename
     * @return \Illuminate\Http\Response
     */
    public function delete($filename)
    {
        $this->postMedia->where('name', $filename)->delete();
        $this->mediaService->delete($filename);
        return response()->json('successfully deleted');
    }
}
