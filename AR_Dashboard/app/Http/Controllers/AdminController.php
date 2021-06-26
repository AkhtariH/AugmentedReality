<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator,Redirect,Response;
use Illuminate\Support\Facades\Hash;
use Session;
use App\Models\User;
use App\Models\ArtObject;
use App\Models\SimulatorSession;

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
        $artObjectsPaginate = ArtObject::paginate(9);
        $approvedCount = ArtObject::where([['status', '=', 'Approved']])->count();
        $pendingCount = ArtObject::where([['status', '=', 'Pending']])->count();
        $rejectedCount = ArtObject::where([['status', '=', 'Rejected']])->count();

        $notificationObjects = ArtObject::where([['status', '=', 'Pending']])->get();
        foreach ($notificationObjects as $object){
            $user = User::find($object->user_id);
            $object->artist = $user->name;
            $object->profile_image = $user->profile_image;
        }
        // TODO: Average Stars

        foreach ($artObjects as $artObject) {
            $user = User::find($artObject->user_id);
            $artObject->username = $user->name;
        }

        return view('admin.index', compact('artObjects', 'approvedCount', 'rejectedCount', 'pendingCount', 'artObjectsPaginate', 'notificationObjects'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ArtObject  $artObject
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $artObject = ArtObject::findOrFail($id);
        $user = User::findOrFail($artObject->user_id);
        return view('admin.edit', compact('artObject', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ArtObject  $artObject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'file' => 'max:1024000',
            'name' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'floatingHeight' => 'required',
	        'description' => 'required'
        ]);
        
        $artObject = ArtObject::findOrFail($id);
        $data = collect($request->except('file'));
        if ($request->has('file')) {
            $extension = substr($request->file->getClientOriginalName(), -3);
            $imageName = time() . '.' . $extension;  
            $content = file_get_contents($request->file);
            
            $request->file->move(public_path('img/uploads/'), $imageName);
            $data->put('file', $imageName);
            $artObject->update([
                'name' => $request->name,
                'description' => $request->description,
                'file_path' => $imageName,
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
                'floatingHeight' => $request->floatingHeight,
                'status' => 'Pending'
            ]);
        } else {
            $artObject->update([
                'name' => $request->name,
                'description' => $request->description,
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
                'floatingHeight' => $request->floatingHeight,
                'status' => 'Pending'
            ]);
        }

        return redirect()->route('admin.index')->with('success', 'The art object has been updated!');
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

    public function simulator($id) {
        SimulatorSession::create([
            'user_id' => Auth()->user()->id,
            'art_object_id' => $id
        ]);

        return redirect()->route('admin.index')->with('success', 'The Simulator Session has been created succesfully!');
    }

}
