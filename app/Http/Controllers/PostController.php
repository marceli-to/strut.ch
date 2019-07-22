<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MediaService;
use App\Http\Resources\PostCollection;
use App\Post;
use App\PostMedia;

class PostController extends Controller
{
    protected $mediaService;

    public function __construct(MediaService $service)
    {
        $this->mediaService = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return new PostCollection(Post::orderBy('order', 'ASC')->get());
        $posts = Post::with(['media' => function($query) {
            $query->orderBy('order', 'ASC');
        }])->orderBy('order', 'ASC')->get();

        return new PostCollection($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = new Post([
            'title' => $request->get('title'),
            'body'  => $request->get('body')
        ]);
        $post->save();

        if (!empty($request->media))
        {
            foreach($request->media as $m)
            {
                $media = new PostMedia([
                    'post_id'   => $post->id,
                    'name'      => $m['name'],
                    'caption'   => $m['caption'],
                    'filetype'  => $m['filetype'],
                ]);
                $media->save();
            }
        }

        return response()->json('success');
    }
    
    /**
     * Edit a specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::with(['media' => function($query) {
            $query->orderBy('order', 'ASC');
        }])->find($id);

        return response()->json($post);
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
        $post = Post::find($id);
        $post->title = $request->get('title');
        $post->body  = $request->get('body');
        $post->save();

        if (!empty($request->media))
        {
            foreach($request->media as $m)
            {
                $media = PostMedia::updateOrCreate(
                    ['id' => $m['id']], 
                    [
                        'post_id'   => $post->id,
                        'name'      => $m['name'],
                        'caption'   => $m['caption'],
                        'filetype'  => $m['filetype'],
                        'order'     => isset($m['order']) ? $m['order'] : 0,
                    ]
                );
            }
        }

        return response()->json('successfully updated');
    }

    /**
     * Delete a specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */    
    public function delete($id)
    {
        // Get the post with post_media
        $post = Post::with('media')->find($id);

        // Delete file & post_media
        if (isset($post->media))
        {
            foreach($post->media as $m)
            {
                $this->mediaService->delete($m->name);
                $m->delete();
            }
        }

        // Delete the post
        $post->delete();
        return response()->json('successfully deleted');
    }

    /**
     * Update the status of the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status($id)
    {
        $post = Post::findOrFail($id);
        $post->publish = $post->publish == 0 ? 1 : 0;
        $post->save();
        return response()->json($post->publish);
    }

    /**
     * Update the order of the resources.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function order(Request $request)
    {
        $posts = $request->get('posts');
        foreach($posts as $p)
        {
            $post = Post::find($p['id']);
            $post->order = $p['order'];
            $post->save(); 
        }
        return response()->json('successfully updated');
    }
}
