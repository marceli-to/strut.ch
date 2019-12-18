<?php
namespace App\Http\Controllers\Backend\Lecture;

use App\Services\MediaService;
use App\Models\Lecture;
use App\Http\Resources\LectureCollection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LectureController extends Controller
{
    protected $mediaService;

    protected $lecture;
    
    /**
     * Constructor
     * 
     * @param MediaService $mediaService
     * @param Lecture $lecture
     */

    public function __construct(MediaService $mediaService, Lecture $lecture)
    {
        $this->mediaService = $mediaService;
        $this->lecture = $lecture;
    }

    /**
     * Get all records
     *
     * @return \Illuminate\Http\Response
     */

    public function get()
    {
        $lectures = $this->lecture->orderBy('year', 'DESC')->get()->groupBy('year');
        return new LectureCollection($lectures);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {   
        $lecture = new Lecture([
            'title' => [
                'de' => $request->input('title.de'),
                'en' => $request->input('title.en'),
            ],
            'description' => [
                'de' => $request->input('description.de'),
                'en' => $request->input('description.en'),
            ],
            'year' => $request->input('year'),          
            'media' => $request->input('media'),
            'url'   => $request->input('url') ? \AppHelper::addScheme($request->input('url')) : NULL,
            'file'  => $request->input('file'),        
        ]);

        $lecture->save();
        return response()->json(['lectureId' => $lecture->id]);
    }

    /**
     * Edit a specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lecture = $this->lecture->findOrFail($id);
        return response()->json($lecture);
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
        $lecture = $this->lecture->findOrFail($id);
        $lecture->setTranslation('title', 'de', $request->input('title.de'));
        $lecture->setTranslation('description', 'de', $request->input('description.de'));
        $lecture->year = $request->input('year') ? $request->input('year') : NULL;
        $lecture->media = $request->input('media') ? $request->input('media') : NULL;
        $lecture->file = $request->input('file') ? $request->input('file') : NULL;
        $lecture->url = $request->input('url') ? \AppHelper::addScheme($request->input('url')) : NULL;
        $lecture->save();
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
        $lecture = $this->lecture->findOrFail($id);
        $lectureCopy = $lecture->replicate();
        $lectureCopy->setTranslation('title', 'de', $lecture->getTranslation('title', 'de') . ' (Kopie)');
        $lectureCopy->media = null;
        $lectureCopy->file = 0;
        $lectureCopy->url = 0;
        $lectureCopy->publish = 0;
        $lectureCopy->save();
        $lectures = $this->lecture->orderBy('year', 'DESC')->get()->groupBy('year');
        return new lectureCollection($lectures);
    }

    /**
     * Update the status of the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status($id)
    {
        $lecture = $this->lecture->findOrFail($id);
        $lecture->publish = $lecture->publish == 0 ? 1 : 0;
        $lecture->save();
        return response()->json($lecture->publish);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lecture = $this->lecture->find($id);
        if ($lecture->media)
        {
            $this->mediaService->delete($lecture->media);
        }
        if ($lecture->file)
        {
            $this->mediaService->delete($lecture->file);
        }
        $lecture->delete();
        $lectures = $this->lecture->orderBy('year', 'DESC')->get()->groupBy('year');
        return new LectureCollection($lectures);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  str $filename
     * @return \Illuminate\Http\Response
     */
    public function unlink($filename)
    {
        $lecture = $this->lecture->where('media', $filename)->first();
        
        // Media
        if ($lecture)
        {
            $lecture->media = null;
            $lecture->save();
        }

        // File
        $lecture = $this->lecture->where('file', $filename)->first();
        if ($lecture)
        {
            $lecture->file = null;
            $lecture->save();
        }

        $this->mediaService->delete($filename);
        return response()->json('successfully deleted');
    }
}
