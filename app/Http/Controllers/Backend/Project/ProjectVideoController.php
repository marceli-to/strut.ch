<?php
namespace App\Http\Controllers\Backend\Project;

use App\Services\MediaService;
use App\Models\ProjectVideo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectVideoController extends Controller
{
    protected $mediaService;
    protected $projectVideo;

    public function __construct(
        MediaService $mediaService,
        ProjectVideo $projectVideo
    ) {
        $this->mediaService = $mediaService;
        $this->projectVideo = $projectVideo;
    }

    public function unlink($filename)
    {
        $video = $this->projectVideo->where('name', $filename)->first();
        if ($video) {
            $video->delete();
        }
        $this->mediaService->delete($filename);
        return response()->json('successfully deleted');
    }

    public function status($id)
    {
        $video = $this->projectVideo->findOrFail($id);
        $video->publish = $video->publish == 0 ? 1 : 0;
        $video->save();
        return response()->json($video->publish);
    }
}
