<?php
namespace App\Http\Controllers\Backend\Job;

use App\Services\MediaService;
use App\Models\Job;
use App\Http\Resources\JobCollection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobController extends Controller
{
    protected $mediaService;

    protected $job;

    /**
     * Constructor
     * 
     * @param MediaService $mediaService
     * @param Job $job
     */
    public function __construct(MediaService $mediaService, Job $job)
    {
        $this->mediaService = $mediaService;
        $this->job = $job;
    }

    /**
     * Get all jobs
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        $jobs = $this->job->orderBy('order', 'ASC')->get();
        return new JobCollection($jobs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $job = new Job([
            'title' => [
                'de' => $request->input('title.de'),
                'en' => $request->input('title.en')
            ],
            'lead' => [
                'de' => $request->input('lead.de'),
                'en' => $request->input('lead.en')
            ],
            'info' => [
                'de' => $request->input('info.de'),
                'en' => $request->input('info.en')
            ],
            'order' => -1,
            'media' =>  $request->input('media')           
        ]);

        $job->save();
        return response()->json(['jobId' => $job->id]);
    }

    /**
     * Edit a specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $job = $this->job->findOrFail($id);
        return response()->json($job);
    }

    /**
     * Update the status of the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status($id)
    {
        $job = $this->job->findOrFail($id);
        $job->publish = $job->publish == 0 ? 1 : 0;
        $job->save();
        return response()->json($job->publish);
    }

    /**
     * Update the order of the resources.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function order(Request $request)
    {
        $jobs = $request->get('jobs');
        foreach($jobs as $j)
        {
            $job = Job::find($j['id']);
            $job->order = $j['order'];
            $job->save(); 
        }
        return response()->json('successfully updated');
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
        $job = $this->job->find($id);
        $job->setTranslation('title', 'de', $request->input('title.de'));
        $job->setTranslation('lead', 'de', $request->input('lead.de'));
        $job->setTranslation('info', 'de', $request->input('info.de'));

        if ($request->input('media'))
        {
            $job->media = $request->input('media');
        }

        $job->save();
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
        $job = $this->job->find($id);

        if ($job->media)
        {
            $this->mediaService->delete($job->media);
        }

        $job->delete();
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
        $job = $this->job->where('media', $filename)->first();
        if ($job)
        {
            $job->media = null;
            $job->save();
        }
        $this->mediaService->delete($filename);
        return response()->json('successfully deleted');
    }

}
