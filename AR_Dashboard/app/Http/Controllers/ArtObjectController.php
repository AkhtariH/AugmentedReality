<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ArtObject;
use App\Models\SimulatorSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Events\ThresholdExceeded;

class ArtObjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $artObjects = ArtObject::where('user_id', Auth()->user()->id)->latest()->paginate(9);
        $objectsCount =  ArtObject::where('user_id', Auth()->user()->id)->count();
        $approvedCount = ArtObject::where([['user_id', '=', Auth()->user()->id], ['status', '=', 'Approved']])->count();
        if (Auth()->user()->isAdmin()) {
            $pendingCount = ArtObject::where([['status', '=', 'Pending']])->count();
            $notificationObjects = ArtObject::where([['status', '=', 'Pending']])->get();
            foreach ($notificationObjects as $object){
                $user = User::find($object->user_id);
                $object->artist = $user->name;
                $object->profile_image = $user->profile_image;
            }
        } else {
            $pendingCount = ArtObject::where([['user_id', '=', Auth()->user()->id], ['status', '=', 'Pending']])->count();
            $notificationObjects = null;
        }
        $rejectedCount = ArtObject::where([['user_id', '=', Auth()->user()->id], ['status', '=', 'Rejected']])->count();
        

        return view('home', compact('artObjects', 'approvedCount', 'objectsCount', 'rejectedCount', 'pendingCount', 'notificationObjects'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|max:1024000',
            'latitude' => 'required',
            'longitude' => 'required',
            'floatingHeight' => 'required',
            'name' => 'required',
	        'description' => 'required'
        ]);
            
        $data = collect($request->except('file'));
        if ($request->has('file')) {
            $extension = substr($request->file->getClientOriginalName(), -3);
            $imageName = time() . '.' . $extension;  
            $content = file_get_contents($request->file);
            
            $request->file->move(public_path('img/uploads/'), $imageName);
            $data->put('file', $imageName);
            ArtObject::create([
                'user_id' => Auth()->user()->id,
                'name' => $request->name,
                'description' => $request->description,
                'file_path' => $imageName,
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
                'floatingHeight' => $request->floatingHeight
            ]);
            $emailData = new \stdClass;
            $emailData->artist = Auth()->user()->name;
            $emailData->profile_image = Auth()->user()->profile_image;
            $emailData->name = $request->name;
            $emailData->description = $request->description;
            event(new ThresholdExceeded($emailData));
        }

        
        return redirect()->route('home.index')->with('success', 'Your art has been uploaded!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ArtObject  $artObject
     * @return \Illuminate\Http\Response
     */
    public function show(ArtObject $artObject)
    {
        //
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

        return view('edithome', compact('artObject'));
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

        return redirect()->route('home.index')->with('success', 'Your art object has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ArtObject  $artObject
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ArtObject::findOrFail($id)->delete();

        return redirect()->route('home.index')->with('success', 'Your art object has been deleted successfully!');
    }

    public function simulator($id) {
        SimulatorSession::create([
            'user_id' => Auth()->user()->id,
            'art_object_id' => $id
        ]);

        return redirect()->route('simulator')->with('success', 'The Simulator Session has been created succesfully!');
    }
}
