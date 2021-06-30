<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;

use App\Models\SimulatorSession;

class SimulatorController extends BaseController
{

    public function deleteSession($id)
    {
        $session = SimulatorSession::findOrFail($id);
        $session->delete();

        return response()->json("Success!", 200);
    }
}
