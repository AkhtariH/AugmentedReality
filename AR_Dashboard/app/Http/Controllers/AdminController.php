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

    public function assign(Request $request) {
        $request->validate([
            'data' => 'required',
            'user' => 'required'
        ]);
        
        $user = User::findOrFail($request->user);
        $supervisorFirstName = explode(' ', $request->data)[0];
        $supervisorLastName = explode(' ', $request->data)[1];
        $supervisor = User::where([
            ['first_name', '=', $supervisorFirstName],
            ['last_name', '=', $supervisorLastName],
        ])->first();
        $userSupervisor = UserSupervisor::where('user_id', $user->id)->first();

        if ($userSupervisor == null) {
            UserSupervisor::create([
                'user_id' => $user->id,
                'supervisor_id' => $supervisor->id
            ]);
        } else {
            $userSupervisor->update([
                'supervisor_id' => $supervisor->id
            ]);
        }

        return response()->json(array('msg', 'Success!'), 200);
    }

    public function deleteAssign(Request $request) {
        $request->validate([
            'user' => 'required'
        ]);
        
        $userSupervisor = UserSupervisor::where('user_id', $request->user)->first();
        $userSupervisor->delete();

        return response()->json(array('msg', 'Success!'), 200);
    }

    public function overtime_email(Request $request) {
        $request->validate([
            'user' => 'required',
            'data' => 'required'
        ]);

        if ($request->data == 'true') {
            $bool = true;
        } else {
            $bool = false;
        }
        
        $user = User::findOrFail($request->user);
        $user->update([
            'overtime_email' => $bool
        ]);

        return response()->json(array('msg', 'Success!'), 200);
    }

    public function overtime_max(Request $request) {
        $request->validate([
            'value' => 'required',
            'user' => 'required'
        ]);
        
        $user = User::findOrFail($request->user);
        $user->update([
            'max_overtime' => $request->value
        ]);

        return response()->json(array('msg', 'Success!'), 200);
    }

}
