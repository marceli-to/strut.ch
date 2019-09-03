<?php
namespace App\Http\Controllers\Backend\Book;

use App\Services\MediaService;
use App\Models\Book;
use App\Http\Resources\BookCollection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $mediaService;

    protected $book;
    
    /**
     * Constructor
     * 
     * @param MediaService $mediaService
     * @param Book $book
     */

    public function __construct(MediaService $mediaService, Book $book)
    {
        $this->mediaService = $mediaService;
        $this->book = $book;
    }

    /**
     * Get all books
     *
     * @return \Illuminate\Http\Response
     */

    public function get()
    {
        $books = $this->book->orderBy('order', 'ASC')->get();
        return new BookCollection($books);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {   
        $book = new Book([
            'title' =>  $request->input('title'),
            'description' => [
                'de' => $request->input('description.de'),
                'en' => $request->input('description.en'),
            ],
            'info' => [
                'de' => $request->input('info.de'),
                'en' => $request->input('info.en'),
            ],
            'url' => $request->input('url') ? \AppHelper::addScheme($request->input('url')) : NULL,
            'media' => $request->input('media'),          
        ]);

        $book->save();
        return response()->json(['bookId' => $book->id]);
    }

    /**
     * Edit a specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = $this->book->findOrFail($id);
        return response()->json($book);
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
        $book = $this->book->findOrFail($id);
        $book->title = $request->input('title');
        $book->setTranslation('description', 'de', $request->input('description.de'));
        $book->setTranslation('info', 'de', $request->input('info.de'));
        $book->media = $request->input('media') ? $request->input('media') : NULL;
        $book->url = $request->input('url') ? \AppHelper::addScheme($request->input('url')) : NULL;
        $book->save();
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
        $book = $this->book->findOrFail($id);
        $bookCopy = $book->replicate();
        $bookCopy->title = $book->title . ' (Kopie)';
        $bookCopy->media = null;
        $bookCopy->publish = 0;
        $bookCopy->save();
        return response()->json($bookCopy);
    }

    /**
     * Update the status of the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status($id)
    {
        $book = $this->book->findOrFail($id);
        $book->publish = $book->publish == 0 ? 1 : 0;
        $book->save();
        return response()->json($book->publish);
    }

    /**
     * Update the order of the resources.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function order(Request $request)
    {
        $books = $request->get('books');

        foreach($books as $book)
        {
            $b = $this->book->find($book['id']);
            $b->order = $book['order'];
            $b->save(); 
        }
        return response()->json('successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = $this->book->find($id);

        if ($book->media)
        {
            $this->mediaService->delete($book->media);
        }

        $book->delete();
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
        $book = $this->book->where('media', $filename)->first();
        if ($book)
        {
            $book->media = null;
            $book->save();
        }
        $this->mediaService->delete($filename);
        return response()->json('successfully deleted');
    }
}
