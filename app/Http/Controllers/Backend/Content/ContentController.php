<?php
namespace App\Http\Controllers\Backend\Content;

use App\Services\MediaService;
use App\Models\Content;
use App\Models\ContentImage;
use App\Http\Resources\ContentCollection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    protected $mediaService;

    protected $content;

    /**
     * Constructor
     * 
     * @param MediaService $mediaService
     * @param Content $content
     * @param ContentImage $contentImage
     */
    public function __construct(MediaService $mediaService, Content $content, ContentImage $contentImage)
    {
        $this->mediaService = $mediaService;
        $this->content = $content;
        $this->contentImage = $contentImage;
    }

    /**
     * Get all jobs
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        $contents = $this->content->with('images')->get();
        return new ContentCollection($contents);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $content = new Content([
            'title' => [
                'de' => $request->input('title.de'),
                'en' => $request->input('title.en')
            ],
            'text' => [
                'de' => $request->input('text.de'),
                'en' => $request->input('text.en')
            ],
        ]);

        $content->save();

        if (!empty($request->images))
        {
            foreach($request->images as $i)
            {
                $image = new ContentImage([
                    'content'  => $content->id,
                    'name'     => $i['name'],
                    'caption'  => $i['caption'],
                    'publish'  => 1,
                ]);
                $image->save();
            }
        }

        return response()->json(['contentId' => $content->id]);
    }

    /**
     * Edit a specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $content = $this->content->with('images')->findOrFail($id);
        return response()->json($content);
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
        $content = $this->content->findOrFail($id);
        $content->setTranslation('title', 'de', $request->input('title.de'));
        $content->setTranslation('text', 'de', $request->input('text.de'));
        $content->save();

        if (!empty($request->images))
        {
            foreach($request->images as $i)
            {
                $image = ContentImage::updateOrCreate(
                    ['id' => $i['id']], 
                    [
                        'content_id' => $content->id,
                        'name'       => $i['name'],
                        'caption'    => $i['caption'],
                        'publish'    => $i['publish'] ? $i['publish'] : 0,
                    ]
                );
            }
        }

        return response()->json('successfully updated');
    }

    /**
     * Update the status of the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status($id)
    {
        $content = $this->content->findOrFail($id);
        $content->publish = $content->publish == 0 ? 1 : 0;
        $content->save();
        return response()->json($content->publish);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  str $filename
     * @return \Illuminate\Http\Response
     */
    public function unlink($filename)
    {
        $image = $this->contentImage->where('name', $filename)->first();
        if ($image)
        {
            $image->delete();
        }
        $this->mediaService->delete($filename);
        return response()->json('successfully deleted');
    }

}
