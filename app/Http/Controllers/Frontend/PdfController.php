<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use PDF;
use iio\libmergepdf\Merger;

use App\Models\Category;
use App\Models\Project;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PdfController extends Controller
{
  protected $category;

  protected $filenamePrefix = 'strut.ch-werkliste-';

  public function __construct(
    Category $category,
    Project $project
  )
  {
    $this->category = $category;
    $this->project  = $project;
  }

  public function byCategory($id, $slug)
  {
    $projects = $this->project->published()
                              ->with('downloads')
                              ->where('category_id', '=', $id)
                              ->get();

    $merger = new Merger();

    foreach($projects as $project)
    {
      foreach($project->downloads as $file)
      {
        $merger->addFile(public_path() .'/storage/media/downloads/' . $file->name);
      }
    }

    $filename = 'strut.ch-Projektdokumentation-' . ucfirst($slug) .'-' . date('d-m-Y:H:i:s') . '.pdf';
    $mergedPdf = $merger->merge();

    return response($mergedPdf, 200, [
      'Content-Type' => 'application/pdf',
      'Content-Disposition' => 'inline; filename="' . $filename . '"',
    ]);
  }

  public function worksAll()
  {
    // Get all projects and group them by categories
    $projects = $this->category->published()
                               ->with('activeTypes.activeProjects')
                               ->get();

    // Get all projects marked as competition
    $competition = $this->project->published()
                                 ->competition()
                                 ->orderBy('status')
                                 ->get();

    // Pdf data
    $data = [
      'title' => 'strut.ch - Werkliste Gesamt',
      'date' => strftime("%d. %B %Y",strtotime(date('d.m.Y', time()))),
      'projects' => $projects->groupBy('name'),
      'competition' => $competition->groupBy('competition')
    ];

    $pdf = PDF::loadView('web.pdf.all', $data);
    return $pdf->stream($this->_getFileName('gesamt'));
  }

  public function worksLiving()
  {
    // Get all projects and group them by categories
    $projects = $this->category->published()
                               ->with('activeTypes.activeProjects')
                               ->where('id', '=', 1)
                               ->get();
                                   
    // Pdf data
    $data = [
      'title' => 'strut.ch - Werkliste Wohnen',
      'date' => strftime("%d. %B %Y",strtotime(date('d.m.Y', time()))),
      'projects' => $projects->groupBy('name'),
    ];
    $pdf = PDF::loadView('web.pdf.living', $data);
    return $pdf->stream($this->_getFileName('wohnen'));
  }

  public function worksBusiness()
  {
    // Get all projects and group them by categories
    $projects = $this->category->published()
                               ->with('activeTypes.activeProjects')
                               ->where('id', '=', 2)
                               ->get();
                                   
    // Pdf data
    $data = [
      'title' => 'strut.ch - Werkliste Gewerbe',
      'date' => strftime("%d. %B %Y",strtotime(date('d.m.Y', time()))),
      'projects' => $projects->groupBy('name'),
    ];
    $pdf = PDF::loadView('web.pdf.business', $data);
    return $pdf->stream($this->_getFileName('gewerbe'));
  }

  public function worksPublic()
  {
    // Get all projects and group them by categories
    $projects = $this->category->published()
                               ->with('activeTypes.activeProjects')
                               ->where('id', '=', 3)
                               ->get();       
    // Pdf data
    $data = [
      'title' => 'strut.ch - Werkliste Öffentlich',
      'date' => strftime("%d. %B %Y",strtotime(date('d.m.Y', time()))),
      'projects' => $projects->groupBy('name'),
    ];
    $pdf = PDF::loadView('web.pdf.public', $data);
    return $pdf->stream($this->_getFileName('oeffentlich'));
  }

  public function worksCompetition()
  {
    // Get all projects marked as competition
    $projects = $this->project->published()
                              ->competition()
                              ->orderBy('status')
                              ->get();
    // Pdf data
    $data = [
      'title'    => 'strut.ch - Werkliste Wettbewerbe',
      'date'     => strftime("%d. %B %Y",strtotime(date('d.m.Y', time()))),
      'projects' => $projects->groupBy('competition'),
    ];

    $pdf = PDF::loadView('web.pdf.competition', $data);
    return $pdf->stream($this->_getFileName('wettbewerbe'));
  }

  public function worksState()
  {
    // Get all projects and group them by it's status
    $projects = $this->project->published()
                              ->with('categoryType')
                              ->orderBy('status')
                              ->orderBy('year', 'DESC')
                              ->orderBy('name')
                              ->get();

    // Get all projects marked as competition
    $competition = $this->project->published()
                                 ->competition()
                                 ->orderBy('status')
                                 ->get();

    // Pdf data
    $data = [
      'title' => 'strut.ch - Werkliste nach Status',
      'date' => strftime("%d. %B %Y",strtotime(date('d.m.Y', time()))),
      'projects' => $projects->groupBy('status'),
      'competition' => $competition->groupBy('competition')
    ];
    $pdf = PDF::loadView('web.pdf.state', $data);
    return $pdf->stream($this->_getFileName('status'));
  }

  public function worksYear()
  {
    // Get all projects and group them by it's status
    $projects = $this->project->published()
                              ->with('categoryType')
                              ->orderBy('year', 'DESC')
                              ->orderBy('name')
                              ->get();
    // Pdf data
    $data = [
      'title' => 'strut.ch - Werkliste nach Jahr',
      'date' => strftime("%d. %B %Y",strtotime(date('d.m.Y', time()))),
      'projects' => $projects->groupBy('year'),
    ];
    $pdf = PDF::loadView('web.pdf.year', $data);
    return $pdf->stream($this->_getFileName('jahr'));
  }

  public function worksType()
  {
    // Get all projects and group them by categories
    $projects = $this->category->published()->with('activeTypes.activeProjects')->get();
    
    // Pdf data
    $data = [
      'title' => 'strut.ch - Werkliste nach Typ',
      'date' => strftime("%d. %B %Y",strtotime(date('d.m.Y', time()))),
      'projects' => $projects->groupBy('name'),
    ];

    $pdf = PDF::loadView('web.pdf.type', $data);
    return $pdf->stream($this->_getFileName('typ'));

  }

  private function _getFileName($type = NULL)
  {
    return $this->filenamePrefix . $type . '-' . date('d.m.Y', time()) . '.pdf';
  }
}
