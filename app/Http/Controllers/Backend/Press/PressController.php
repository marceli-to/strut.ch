<?php
namespace App\Http\Controllers\Backend\Press;

use App\Services\MediaService;
use App\Models\Press;
use App\Http\Resources\PressCollection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PressController extends Controller
{
    protected $mediaService;
    protected $press;
    
    /**
     * Constructor
     * 
     * @param MediaService $mediaService
     * @param Press $press
     */

    public function __construct(
        MediaService $mediaService,
        Press $press
    )
    {
        $this->mediaService = $mediaService;
        $this->press = $press;
    }

    /**
     * Get all records
     *
     * @return \Illuminate\Http\Response
     */

    public function get($year = NULL)
    {
        if ($year !== NULL)
        {
            $press = $this->press->where('year', '=', $year)
                                 ->orderBy('year', 'DESC')
                                 ->with('project')
                                 ->get()
                                 ->groupBy('year');

        }
        else
        {
            $press = $this->press->orderBy('year', 'DESC')
                                 ->with('project')
                                 ->get()
                                 ->groupBy('year');
        }
        return new PressCollection($press);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {   
        $press = new Press([
            'title' => [
                'de' => $request->input('title.de'),
                'en' => $request->input('title.en'),
            ],
            'description' => [
                'de' => $request->input('description.de'),
                'en' => $request->input('description.en'),
            ],
            'year'        => $request->input('year'),          
            'url'         => $request->input('url') ? \AppHelper::addScheme($request->input('url')) : NULL,
            'media'       => $request->input('media'),  
            'file'        => $request->input('file'),          
            'project_id'  => $request->input('project_id'),          
        ]);

        $press->save();
        return response()->json(['pressId' => $press->id]);
    }

    /**
     * Edit a specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $press = $this->press->findOrFail($id);
        return response()->json($press);
    }

    /**
     * Update the status of the specified resource.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $press = $this->press->findOrFail($id);
        $press->setTranslation('title', 'de', $request->input('title.de'));
        $press->setTranslation('description', 'de', $request->input('description.de'));
        $press->year = $request->input('year') ? $request->input('year') : NULL;
        $press->media = $request->input('media') ? $request->input('media') : NULL;
        $press->file = $request->input('file') ? $request->input('file') : NULL;
        $press->url = $request->input('url') ? \AppHelper::addScheme($request->input('url')) : NULL;
        $press->project_id = $request->input('project_id') ? $request->input('project_id') : NULL;
        $press->save();
        return response()->json('successfully updated');
    }

    /**
     * Clone a specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function clone($id)
    {
        $press = $this->press->findOrFail($id);
        $pressCopy = $press->replicate();
        $pressCopy->setTranslation('title', 'de', $press->getTranslation('title', 'de') . ' (Kopie)');
        $pressCopy->media = null;
        $pressCopy->file = null;
        $pressCopy->project_id = null;
        $pressCopy->publish = 0;
        $pressCopy->save();
        $press = $this->press->orderBy('year', 'DESC')->get()->groupBy('year');
        return new PressCollection($press);
    }

    /**
     * Update the status of the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status($id)
    {
        $press = $this->press->findOrFail($id);
        $press->publish = $press->publish == 0 ? 1 : 0;
        $press->save();
        return response()->json($press->publish);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $press = $this->press->find($id);
        if ($press->media)
        {
            $this->mediaService->delete($press->media);
        }
        if ($press->file)
        {
            $this->mediaService->delete($press->file);
        }
        $press->delete();
        $press = $this->press->orderBy('year', 'DESC')->get()->groupBy('year');
        return new PressCollection($press);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  str $filename
     * @return \Illuminate\Http\Response
     */
    public function unlink($filename)
    {
        // Delete image
        $press_media = $this->press->where('media', $filename)->first();
        if ($press_media)
        {
            $press_media->media = null;
            $press_media->save();
        }

        // Delete file
        $press_file = $this->press->where('file', $filename)->first();
        if ($press_file)
        {
            $press_file->file = null;
            $press_file->save();
        }

        // Delete the image/file from the disk
        $this->mediaService->delete($filename);
        return response()->json('successfully deleted');
    }
}
