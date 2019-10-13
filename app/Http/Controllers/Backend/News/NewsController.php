<?php
namespace App\Http\Controllers\Backend\News;

use App\Services\MediaService;
use App\Services\GridService;
use App\Models\News;
use App\Http\Resources\NewsCollection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    protected $mediaService;
    protected $gridService;
    protected $news;

    public function __construct(MediaService $mediaService, News $news, GridService $gridService)
    {
        $this->mediaService = $mediaService;
        $this->gridService = $gridService;
        $this->news = $news;
    }

    /**
     * Get all records
     *
     * @return \Illuminate\Http\Response
     */

    public function get()
    {
        $news = $this->news->orderBy('date->de', 'ASC')->get();
        return new NewsCollection($news);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $news = new News([
            'date' => [
                'de' => $request->input('date.de'),
            ],
            'subtitle' => [
                'de' => $request->input('subtitle.de'),
            ],
            'title' => [
                'de' => $request->input('title.de'),
            ],
            'text' => [
                'de' => $request->input('text.de'),
            ],
            'link' => [
                'de' => $request->input('link.de'),
            ],  
            'linkText' => [
                'de' => $request->input('linkText.de'),
            ],
            'media' => $request->input('media'),
        ]);

        $news->save();
        return response()->json(['newsId' => $news->id]);
    }

    /**
     * Edit a specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $news = $this->news->findOrFail($id);
        return response()->json($news);
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
        $news = $this->news->findOrFail($id);
        $news->setTranslation('date', 'de', $request->input('date.de'));
        $news->setTranslation('subtitle', 'de', $request->input('subtitle.de'));
        $news->setTranslation('title', 'de', $request->input('title.de'));
        $news->setTranslation('text', 'de', $request->input('text.de'));
        $news->setTranslation('link', 'de', $request->input('link.de') ? \AppHelper::addScheme($request->input('link.de')) : NULL);
        $news->setTranslation('linkText', 'de', $request->input('linkText.de'));
        $news->media = $request->input('media') ? $request->input('media') : NULL;
        $news->save();
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
        $news = $this->news->findOrFail($id);
        $newsCopy = $news->replicate();
        $newsCopy->setTranslation('title', 'de', $news->getTranslation('title', 'de') . ' (Kopie)');
        $newsCopy->media = null;
        $newsCopy->publish = 0;
        $newsCopy->save();
        return response()->json($newsCopy);
    }

    /**
     * Update the status of the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status($id)
    {
        $news = $this->news->findOrFail($id);
        $news->publish = $news->publish == 0 ? 1 : 0;
        $news->save();
        return response()->json($news->publish);
    }

/**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->gridService->isGridNews($id))
        {
            return response()->json(
                'Dieser News-Eintrag kann nicht gelöscht werden. (Grund: wird auf Homepage verwendet)',
                422
            );
        }

        $news = $this->news->find($id);
        if ($news->media)
        {
            $this->mediaService->delete($news->media);
        }
        $news->delete();
        return response()->json('successfully deleted');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  str $filename
     * @return \Illuminate\Http\Response
     */
    public function unlink($filename)
    {
        $news = $this->news->where('media', $filename)->first();
        if ($news)
        {
            $news->media = null;
            $news->save();
        }
        $this->mediaService->delete($filename);
        return response()->json('successfully deleted');
    }
}
