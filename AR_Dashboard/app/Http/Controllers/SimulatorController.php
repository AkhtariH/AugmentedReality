<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SimulatorSession;
use App\Models\ArtObject;

class SimulatorController extends Controller
{
    public function show() {
        $session = SimulatorSession::where([
            ['user_id', '=', Auth()->user()->id]
        ])->first();

        $object = ArtObject::findOrFail($session->art_object_id);
        $pendingCount = null;
        $notificationObjects = null;
        return view('simulator', compact('session', 'object', 'pendingCount', 'notificationObjects'));
    }

    public function endSession($id) {
        $session = SimulatorSession::findOrFail($id);
        $session->delete();

        return response()->json("Success!", 200);
    }
}
