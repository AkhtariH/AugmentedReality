<?php

namespace App\Http\Controllers;

use App\Models\ArtObject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArtObjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $artObjects = ArtObject::where('user_id', Auth()->user()->id)->get();
        $approvedCount = ArtObject::where([['user_id', '=', Auth()->user()->id], ['status', '=', 'Approved']])->count();
        $rejectedCount = ArtObject::where([['user_id', '=', Auth()->user()->id], ['status', '=', 'Rejected']])->count();
        // TODO: Average Stars

        return view('home', compact('artObjects', 'approvedCount', 'rejectedCount'));
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
                'longitude' => 0,
                'latitude' => 0,
                'floatingHeight' => 0
            ]);
        }

        return redirect()->route('home.index')->with('success', 'Your profile has been updated!');
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
        $artObject = ArtObject::findOrFail($id)->first();

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
                'file_path' => $imageName
            ]);
        } else {
            $artObject->update([
                'name' => $request->name,
                'description' => $request->description
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
}
