<?php
namespace App\Http\Controllers\Backend\Project;

use App\Services\MediaService;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\ProjectGridElement;
use App\Http\Resources\ProjectImageCollection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectImageController extends Controller
{
    protected $mediaService;

    protected $project;
    
    protected $projectImage;

    protected $projectGridElement;

    /**
     * Constructor
     * 
     * @param MediaService $mediaService
     * @param Project $project
     */

    public function __construct(
        MediaService $mediaService,
        Project $project,
        ProjectImage $projectImage,
        ProjectGridElement $projectGridElement
    )
    {
        $this->mediaService         = $mediaService;
        $this->project              = $project;
        $this->projectImage         = $projectImage;
        $this->projectGridElement   = $projectGridElement;
    }

    /**
     * Get all published records
     *
     * @param int $projectId
     * @return \Illuminate\Http\Response
     */

    public function get($projectId = NULL)
    {
        $projectImages = $this->projectImage
                              ->where('project_id', '=', $projectId)
                              ->where('publish', '=', 1)
                              ->notInGrid()
                              ->get();

        return new ProjectImageCollection($projectImages);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  str $filename
     * @return \Illuminate\Http\Response
     */
    public function unlink($filename)
    {
        $image = $this->projectImage->where('name', $filename)->first();
        if ($image)
        {
            // Delete grid element
            $gridElement = $this->projectGridElement->where('project_image_id', $image->id)->first();
            if ($gridElement)
            {
                $gridElement->delete();
            }
            
            // Delete image
            $image->delete();
        }
        $this->mediaService->delete($filename);
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
        $image = $this->projectImage->findOrFail($id);
        $image->publish = $image->publish == 0 ? 1 : 0;
        $image->save();
        return response()->json($image->publish);
    }
}
