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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            'file' => 'required|max:2048',
        ]);
            
        $data = collect($request->except('file'));
        if ($request->has('file')) {
            $extension = substr($request->file->getClientOriginalName(), -3);
            $imageName = time() . '.' . $extension;  
            $content = file_get_contents($request->file);
            
            $request->file->move(public_path('img/uploads/'), $imageName);
            $data->put('file', $imageName);
            ArtObject::create([
                'user_id' => 1,
                'name' => 'Test',
                'description' => 'Test',
                'file_path' => $imageName,
                'longitude' => 0.0,
                'latitude' => 0.0,
                'floatingHeight' => 0
            ]);
        }



        return redirect()->route('home')->with('success', 'Your profile has been updated!');
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
    public function edit(ArtObject $artObject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ArtObject  $artObject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ArtObject $artObject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ArtObject  $artObject
     * @return \Illuminate\Http\Response
     */
    public function destroy(ArtObject $artObject)
    {
        //
    }
}
