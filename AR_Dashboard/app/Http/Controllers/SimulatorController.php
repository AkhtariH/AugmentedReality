<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SimulatorSession;

class SimulatorController extends Controller
{
    public function index() {
        $id = SimulatorSession::where('user_id', Auth()->user()->id)->first()->id;
        $pendingCount = null;
        $notificationObjects = null;
        return view('simulator', compact('id', 'pendingCount', 'notificationObjects'));
    }
}
