<?php
namespace App\Http\Controllers\Backend\Award;

use App\Services\MediaService;
use App\Models\Award;
use App\Http\Resources\AwardCollection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AwardController extends Controller
{
    protected $mediaService;

    protected $award;
    
    /**
     * Constructor
     * 
     * @param MediaService $mediaService
     * @param Award $award
     */

    public function __construct(MediaService $mediaService, Award $award)
    {
        $this->mediaService = $mediaService;
        $this->award = $award;
    }

    /**
     * Get all records
     *
     * @return \Illuminate\Http\Response
     */

    public function get()
    {
        $awards = $this->award->orderBy('year', 'DESC')->get()->groupBy('year');
        return new AwardCollection($awards);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {   
        $award = new Award([
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

        $award->save();
        return response()->json(['awardId' => $award->id]);
    }

    /**
     * Edit a specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $award = $this->award->findOrFail($id);
        return response()->json($award);
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
        $award = $this->award->findOrFail($id);
        $award->setTranslation('title', 'de', $request->input('title.de'));
        $award->setTranslation('description', 'de', $request->input('description.de'));
        $award->year = $request->input('year') ? $request->input('year') : NULL;
        $award->media = $request->input('media') ? $request->input('media') : NULL;
        $award->file = $request->input('file') ? $request->input('file') : NULL;
        $award->url = $request->input('url') ? \AppHelper::addScheme($request->input('url')) : NULL;
        $award->save();
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
        $award = $this->award->findOrFail($id);
        $awardCopy = $award->replicate();
        $awardCopy->setTranslation('title', 'de', $award->getTranslation('title', 'de') . ' (Kopie)');
        $awardCopy->media = null;
        $awardCopy->file = null;
        $awardCopy->url = null;
        $awardCopy->publish = 0;
        $awardCopy->save();
        $awards = $this->award->orderBy('year', 'DESC')->get()->groupBy('year');
        return new AwardCollection($awards);
    }

    /**
     * Update the status of the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status($id)
    {
        $award = $this->award->findOrFail($id);
        $award->publish = $award->publish == 0 ? 1 : 0;
        $award->save();
        return response()->json($award->publish);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $award = $this->award->find($id);

        if ($award->media)
        {
            $this->mediaService->delete($award->media);
        }
        if ($award->file)
        {
            $this->mediaService->delete($award->file);
        }
        $award->delete();

        $awards = $this->award->orderBy('year', 'DESC')->get()->groupBy('year');
        return new AwardCollection($awards);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  str $filename
     * @return \Illuminate\Http\Response
     */
    public function unlink($filename)
    {
        // Media
        $award = $this->award->where('media', $filename)->first();
        if ($award)
        {
            $award->media = null;
            $award->save();
        }

        // File
        $award = $this->award->where('file', $filename)->first();
        if ($award)
        {
            $award->file = null;
            $award->save();
        }

        $this->mediaService->delete($filename);
        return response()->json('successfully deleted');
    }
}
