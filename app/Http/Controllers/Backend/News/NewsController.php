<?php

namespace App\Http\Controllers\Backend\News;

use App\Services\MediaService;
use App\Models\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    protected $mediaService;

    protected $news;

    public function __construct(MediaService $service, News $news)
    {
        $this->mediaService = $service;
        $this->news = $news;
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
                'en' => $request->input('date.en')
            ],
            'title' => [
                'de' => $request->input('title.de'),
                'en' => $request->input('title.en')
            ],
            'text' => [
                'de' => $request->input('text.de'),
                'en' => $request->input('text.en')
            ],          
        ]);

        $news->save();
        return response()->json(['newsId' => $news->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $news = $this->news->find($id);
        $news->delete();
        return response()->json('success');
    }
}
