<?php
namespace App\Http\Controllers\Backend\Project;

use App\Services\MediaService;
use App\Models\Category;
use App\Models\CategoryType;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryTypeCollection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryTypeController extends Controller
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
        $categoryTypes = $this->categoryType->with('category')->orderBy('order', 'ASC')->get();
        return new CategoryTypeCollection($categoryTypes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {   
        $categoryType = new CategoryType([
            'name_singular' => [
                'de' => $request->input('name_singular.de'),
                'en' => $request->input('name_singular.en'),
            ],
            'name_plural' => [
                'de' => $request->input('name_plural.de'),
                'en' => $request->input('name_plural.en'),
            ],
            'category_id' => $request->input('category_id'),
        ]);

        $categoryType->save();
        return response()->json(['categoryTypeId' => $categoryType->id]);
    }

    /**
     * Edit a specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categoryType = $this->categoryType->findOrFail($id);
        return response()->json($categoryType);
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
        $categoryType = $this->categoryType->findOrFail($id);
        $categoryType->setTranslation('name_singular', 'de', $request->input('name_singular.de'));
        $categoryType->setTranslation('name_plural', 'de', $request->input('name_plural.de'));
        $categoryType->category_id = $request->input('category_id');
        $categoryType->save();
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
        $categoryType = $this->categoryType->findOrFail($id);
        $categoryTypeCopy = $categoryType->replicate();
        $categoryTypeCopy->setTranslation('name_singular', 'de', $categoryType->getTranslation('name_singular', 'de') . ' (Kopie)');
        $categoryTypeCopy->setTranslation('name_plural', 'de', $categoryType->getTranslation('name_plural', 'de') . ' (Kopie)');
        $categoryTypeCopy->publish = 0;
        $categoryTypeCopy->save();
        $categoryTypes = $this->categoryType->with('category')->orderBy('order', 'ASC')->get();
        return new CategoryTypeCollection($categoryTypes);
    }

    /**
     * Update the status of the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status($id)
    {
        $categoryType = $this->categoryType->findOrFail($id);
        $categoryType->publish = $categoryType->publish == 0 ? 1 : 0;
        $categoryType->save();
        return response()->json($categoryType->publish);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categoryType = $this->categoryType->find($id);
        $categoryType->delete();
        $categoryTypes = $this->categoryType->with('category')->orderBy('order', 'ASC')->get();
        return new CategoryTypeCollection($categoryTypes);
    }
}
