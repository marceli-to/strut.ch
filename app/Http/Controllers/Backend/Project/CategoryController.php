<?php
namespace App\Http\Controllers\Backend\Project;

use App\Services\MediaService;
use App\Models\Category;
use App\Models\CategoryType;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryTypeCollection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $category;
    protected $categoryType;
    
    /**
     * Constructor
     * 
     * @param Category $category
     * @param CategoryType $categoryType
     */

    public function __construct(Category $category, CategoryType $categoryType)
    {
        $this->category     = $category;
        $this->categoryType = $categoryType;
    }

    /**
     * Get all records
     *
     * @return \Illuminate\Http\Response
     */

    public function get()
    {
        $categories = $this->category->with(['types' => function($query) {
            $query->orderBy('order', 'ASC');
        }])->orderBy('order', 'ASC')->get();        
        return new CategoryCollection($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {   
        $category = new Category([
            'name' => [
                'de' => $request->input('name.de'),
                'en' => $request->input('name.en'),
            ],
        ]);

        $category->save();
        return response()->json(['categoryId' => $category->id]);
    }

    /**
     * Edit a specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = $this->category->find($id);
        return response()->json($category);
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
        $category = $this->category->findOrFail($id);
        $category->setTranslation('name', 'de', $request->input('name.de'));
        $category->save();
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
        $category = $this->category->findOrFail($id);
        $categoryCopy = $category->replicate();
        $categoryCopy->setTranslation('name', 'de', $category->getTranslation('name', 'de') . ' (Kopie)');
        $categoryCopy->publish = 0;
        $categoryCopy->save();
        $categories = $this->category->with('types')->orderBy('order', 'ASC')->get();
        return new CategoryCollection($categories);
    }

    /**
     * Update the status of the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status($id)
    {
        $category = $this->category->findOrFail($id);
        $category->publish = $category->publish == 0 ? 1 : 0;
        $category->save();

        // update child elements if parent is unpublished
        if ($category->publish == 0)
        {
            $types = $this->categoryType->where('category_id', '=', $category->id)->get();
            foreach($types as $t)
            {
                $t->publish = 0;
                $t->save();
            } 
        }
        
        return response()->json($category->publish);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = $this->category->find($id);
        $category->delete();
        $categories = $this->category->with('types')->orderBy('order', 'ASC')->get();
        return new CategoryCollection($categories);
    }
}
