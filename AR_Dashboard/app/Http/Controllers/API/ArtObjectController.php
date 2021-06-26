<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\ArtObject as ArtObjectResource;

use App\Models\ArtObject;
use App\Models\SimulatorSession;

class ArtObjectController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $artObjects = ArtObject::all();

        return $this->sendResponse(ArtObjectResource::collection($artObjects), 'ArtObject retrieved successfully.');
    }

    public function simulator()
    {
        $session = SimulatorSession::where('user_id', Auth()->user()->id);
        $artObject = ArtObject::findOrFail($session->art_object_id);

        return $this->sendResponse(new ArtObjectResource($artObject), 'ArtObject retrieved successfully.');
    }
}
