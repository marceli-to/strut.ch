<?php
namespace App\Services;

use App\Models\Project;
use App\Models\Category;
use App\Models\CategoryType;

use Illuminate\Http\Request;

class NavigationService
{
    // Menu item active class
    protected $active = 'is-active';

    // Models
    protected $project;
    protected $category;
    protected $categoryType;

    public function __construct(
        Project $project,
        Category $category,
        CategoryType $categoryType
    )
    {
        $this->project = $project;
        $this->category = $category;
        $this->categoryType = $categoryType;
    }

    public function boot()
    {
        $menu = [
            'projects' => $this->getProjects()
        ];

        return $menu;
    }

    /**
     * Get all projects
     * 
     * @param int $projectId
     * @param 
     */

    private function getProjects($projectId = NULL, $categoryId = NULL, $typeId = NULL)
    {
        $categories = $this->category->with('types.projects')->get();
        $menu_projects = [];
        foreach($categories as $index => $category)
        {
            $menu_projects[$index]['route']         = str_slug(\AppHelper::transliterate($category->getTranslation('name', 'de')), '-');
            $menu_projects[$index]['name']          = $category->getTranslation('name', 'de');
            $menu_projects[$index]['is-active']     = FALSE;
            $menu_projects[$index]['is-clickable']  = FALSE;
            $menu_projects[$index]['show_types']    = (bool) $category->show_types;
            
            foreach($category->types as $idx => $type)
            {
                if (count($type->projects) > 0)
                {
                    $menu_projects[$index]['types'][$idx]['route']        = str_slug(\AppHelper::transliterate($type->getTranslation('name_plural', 'de')), '-');
                    $menu_projects[$index]['types'][$idx]['name']         = $type->getTranslation('name_plural', 'de');
                    $menu_projects[$index]['types'][$idx]['is-active']    = FALSE;
                    $menu_projects[$index]['types'][$idx]['is-visible']   = (bool) $type->visible;
                    $menu_projects[$index]['types'][$idx]['is-clickable'] = FALSE;

                    $type_name_singular = $type->getTranslation('name_singular', 'de');

                    foreach($type->projects as $i => $p)
                    {
                        $menu_projects[$index]['types'][$idx]['projects'][$i]['name'] = $type_name_singular . ', ' . $p->getTranslation('location', 'de');
                        $menu_projects[$index]['types'][$idx]['projects'][$i]['slug'] = 
                            str_slug(
                                \AppHelper::transliterate($p->getTranslation('name', 'de')) . '-' .
                                \AppHelper::transliterate($p->getTranslation('location', 'de')) . '-' .
                                $p->year
                            , '-') . '/' . $p->id;
                    }
                }
            }
        }

        $menu = [
            'name'  => 'Bauten',
            'route' => 'bauten',
            'is-clickable' => FALSE,
            'categories' => $menu_projects
        ];

        return $menu;
    }
}