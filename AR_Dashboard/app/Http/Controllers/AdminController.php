<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator,Redirect,Response;
use Illuminate\Support\Facades\Hash;
use Session;
use App\Models\User;
use App\Models\ArtObject;

use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;


class AdminController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $artObjects = ArtObject::all();
        $approvedCount = ArtObject::where([['status', '=', 'Approved']])->count();
        $pendingCount = ArtObject::where([['status', '=', 'Pending']])->count();
        $rejectedCount = ArtObject::where([['status', '=', 'Rejected']])->count();
        // TODO: Average Stars

        foreach ($artObjects as $artObject) {
            $user = User::find($artObject->user_id);
            $artObject->username = $user->name;
        }

        return view('admin.index', compact('artObjects', 'approvedCount', 'rejectedCount', 'pendingCount'));
    }

    public function approve($id) {
        $artObject = ArtObject::findOrFail($id);
        $artObject->update([
            'status' => 'Approved'
        ]);

        return redirect()->route('admin.index')->with('success', 'The art object has been approved!');
    }

    public function reject($id) {
        $artObject = ArtObject::findOrFail($id);
        $artObject->update([
            'status' => 'Rejected'
        ]);

        return redirect()->route('admin.index')->with('success', 'The art object has been rejected!');
    }

}
