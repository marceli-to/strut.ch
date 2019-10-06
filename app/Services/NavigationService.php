<?php
namespace App\Services;

use App\Models\Project;
use App\Models\Category;
use App\Models\CategoryType;
use Illuminate\Support\Facades\Route;
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

    public function boot($projectId = NULL, $categoryId = NULL, $typeId = NULL)
    {
        $menu = [
            'projects'      => $this->getProjects($projectId,$categoryId,$typeId),
            'works'         => $this->getWorks(),
            'publications'  => $this->getPublications(),
            'contact'       => $this->getContact(),
            'about'         => $this->getAbout(),
        ];

        return $menu;
    }

    /**
     * Build project menu
     * 
     * @param int $projectId
     * @param int $categoryId
     * @param int $categoryTypeId
     */

    private function getProjects($projectId = NULL, $categoryId = NULL, $typeId = NULL)
    {
        $categories = $this->category->with('activeTypes.activeProjects')->get();

        $menu_projects = [];
        foreach($categories as $index => $category)
        {
            $menu_projects[$index]['slug']          = str_slug(\AppHelper::transliterate($category->getTranslation('name', 'de')), '-');
            $menu_projects[$index]['name']          = $category->getTranslation('name', 'de');
            $menu_projects[$index]['is-active']     = $categoryId == $category->id ? TRUE : FALSE;
            $menu_projects[$index]['is-clickable']  = FALSE;
            $menu_projects[$index]['show_types']    = (bool) $category->show_types;
            
            if (count($category->activeTypes) > 0)
            {
                foreach($category->activeTypes as $idx => $type)
                {
                    if (count($type->activeProjects) > 0)
                    {
                        $menu_projects[$index]['types'][$idx]['slug']         = str_slug(\AppHelper::transliterate($type->getTranslation('name_plural', 'de')), '-');
                        $menu_projects[$index]['types'][$idx]['name']         = $type->getTranslation('name_plural', 'de');
                        $menu_projects[$index]['types'][$idx]['is-active']    = $typeId == $type->id ? TRUE : FALSE;
                        $menu_projects[$index]['types'][$idx]['is-visible']   = (bool) $type->visible;
                        $menu_projects[$index]['types'][$idx]['is-clickable'] = FALSE;

                        $type_name_singular = $type->getTranslation('name_singular', 'de');

                        foreach($type->activeProjects as $i => $p)
                        {
                            $menu_projects[$index]['types'][$idx]['projects'][$i]['name']       = $p->getTranslation('name', 'de') . ', ' . $p->getTranslation('location', 'de');
                            $menu_projects[$index]['types'][$idx]['projects'][$i]['route']      = 'bauten';
                            $menu_projects[$index]['types'][$idx]['projects'][$i]['is-active']  = $projectId == $p->id ? TRUE : FALSE;
                            $menu_projects[$index]['types'][$idx]['projects'][$i]['slug']       = 
                                $p->id .'/'.
                                str_slug(
                                    \AppHelper::transliterate($p->getTranslation('name', 'de')) . '-' .
                                    \AppHelper::transliterate($p->getTranslation('location', 'de')) . '-' .
                                    $p->year
                                , '-');
                        }
                    }
                }
            }
        }

        $menu = [
            'name'       => 'Bauten',
            'slug'       => 'bauten',
            'route'      => 'page.projects',
            'is-parent'  => TRUE,
            'items'      => $menu_projects
        ];

        return $menu;
    }

    /**
     * Build works
     * 
     */

    private function getWorks()
    {
        $menu = [
            'name'      => 'Werkliste',
            'slug'      => 'werkliste',
            'route'     => 'page.works',
            'is-active' => Route::currentRouteName() == 'page.works' ? TRUE : FALSE
        ];
        return $menu;        
    }

    /**
     * Build publications menu
     * 
     */

    private function getPublications()
    {
        $menu_items[] = [
            'name'      => 'Presse',
            'slug'      => 'presse',
            'route'     => 'page.press',
            'is-parent' => FALSE,
            'is-active' => Route::currentRouteName() == 'page.press' ? TRUE : FALSE
        ];

        $menu_items[] = [
            'name'      => 'Bücher',
            'slug'      => 'buecher',
            'route'     => 'page.books',
            'is-parent' => FALSE,
            'is-active' => Route::currentRouteName() == 'page.books' ? TRUE : FALSE
        ];

        $menu_items[] = [
            'name'      => 'Downloads',
            'slug'      => 'downloads',
            'route'     => 'page.downloads',
            'is-parent' => FALSE,
            'is-active' => Route::currentRouteName() == 'page.downloads' ? TRUE : FALSE
        ];

        $menu = [
            'name'      => 'Publikationen',
            'slug'      => 'publikationen',
            'route'     => '',
            'is-parent' => TRUE,
            'is-active' => 
                Route::currentRouteName() == 'page.press' ||
                Route::currentRouteName() == 'page.books' ||
                Route::currentRouteName() == 'page.downloads'
                 ? TRUE : FALSE,
            'items' => $menu_items
        ];

        return $menu;  
    }

    /**
     * Build about menu
     * 
     */

    private function getAbout()
    {
        $menu_items[] = [
            'name'      => 'Über uns',
            'slug'      => 'ueber-uns',
            'route'     => 'page.about',
            'is-parent' => FALSE,
            'is-active' => Route::currentRouteName() == 'page.about' ? TRUE : FALSE
        ];

        $menu_items[] = [
            'name'      => 'Jobs',
            'slug'      => 'jobs',
            'route'     => 'page.jobs',
            'is-parent' => FALSE,
            'is-active' => Route::currentRouteName() == 'page.jobs' ? TRUE : FALSE
        ];

        $menu_items[] = [
            'name'      => 'Auszeichnungen',
            'slug'      => 'auszeichnungen',
            'route'     => 'page.awards',
            'is-parent' => FALSE,
            'is-active' => Route::currentRouteName() == 'page.awards' ? TRUE : FALSE
        ];

        $menu_items[] = [
            'name'      => 'Vorträge',
            'slug'      => 'vortraege',
            'route'     => 'page.lectures',
            'is-parent' => FALSE,
            'is-active' => Route::currentRouteName() == 'page.lectures' ? TRUE : FALSE
        ];

        $menu = [
            'name'      => 'Büro',
            'slug'      => 'buero',
            'route'     => '',
            'is-parent' => TRUE,
            'is-active' => 
                Route::currentRouteName() == 'page.about' ||
                Route::currentRouteName() == 'page.jobs' ||
                Route::currentRouteName() == 'page.awards' ||
                Route::currentRouteName() == 'page.lectures'
                 ? TRUE : FALSE,
            'items' => $menu_items
        ];

        return $menu;  
    }

    /**
     * Build contact menu
     * 
     */

    private function getContact()
    {
        $menu = [
            'name'      => 'Kontakt',
            'slug'      => 'kontakt',
            'route'     => 'page.contact',
            'is-active' => Route::currentRouteName() == 'page.contact' ? TRUE : FALSE
        ];
        return $menu;        
    }
}