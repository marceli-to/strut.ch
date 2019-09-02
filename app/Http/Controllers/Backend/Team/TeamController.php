<?php

namespace App\Http\Controllers\Backend\Team;

use App\Services\MediaService;
use App\Models\Team;
use App\Http\Resources\TeamCollection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    protected $mediaService;

    protected $team;
    
    /**
     * Constructor
     * 
     * @param MediaService $mediaService
     * @param Team $team
     */

    public function __construct(MediaService $mediaService, Team $team)
    {
        $this->mediaService = $mediaService;
        $this->team = $team;
    }

    /**
     * Get all teammembers
     *
     * @return \Illuminate\Http\Response
     */

    public function get()
    {
        $team = $this->team->orderBy('order', 'ASC')->get();
        return new TeamCollection($team);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {   
        $team = new Team([
            'name'      =>  $request->input('name'),
            'firstname' =>  $request->input('media'),
            'role' => [
                'de' => $request->input('role.de'),
                'en' => $request->input('role.en'),
            ],
            'position' => [
                'de' => $request->input('position.de'),
                'en' => $request->input('position.en'),
            ],
            'phone' =>  $request->input('phone'),
            'email' =>  $request->input('email'),
            'media' =>  $request->input('media'),          
            'cv' => [
                'de' => $request->input('cv.de'),
                'en' => $request->input('cv.en')
            ],
            'order' => -1,
        ]);

        $team->save();
        return response()->json(['teamId' => $team->id]);
    }
}
