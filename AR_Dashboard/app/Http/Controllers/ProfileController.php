<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Models\Overtime;
use App\Models\Timesheet;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth()->user();
        $entries = Timesheet::where('user_id', Auth()->user()->id)
            ->select('id', 'date_from', 'date_to', 'time_from', 'time_to', 'break_in_minutes')
            ->orderBy('date_to', 'desc')
            ->limit(5)
            ->get();

        $supervisor = User::join('user_supervisors', 'users.id', '=', 'user_supervisors.supervisor_id')
            ->where('user_supervisors.user_id', Auth()->user()->id)
            ->select('users.*')
            ->first();

        $entriesLength = Timesheet::where('user_id', Auth()->user()->id)
            ->count();

        $overtimeObject = Overtime::where('user_id', Auth()->user()->id)->first();
        if ($overtimeObject === null) {
            $overtime = 0;
        } else {
            $overtime = $overtimeObject->value;
        }

        foreach($entries as $entry) {
            $start = Carbon::parse($entry->time_from);
            $end = Carbon::parse($entry->time_to);

            $dateRegFrom = preg_replace('/\//', '.$2$1', $entry->date_from);
            $dateRegTo = preg_replace('/\//', '.$2$1', $entry->date_to);
            $datediff = strtotime($dateRegTo) - strtotime($dateRegFrom);
            $datediff = (int) round($datediff / (60 * 60 * 24)) + 1;

            $minutes = ($end->diffInMinutes($start) - $entry->break_in_minutes) * $datediff; 
            $hours = floor($minutes / 60);
            $minutes = ($minutes % 60);
            
            $entry->hours = sprintf('%02d', $hours) . 'h ' .sprintf('%02d', $minutes) . 'min'; 
        }

        return view('profile.index', compact('user', 'entries', 'entriesLength', 'overtime', 'supervisor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth()->user()->id == $id) {
            $user = Auth()->user();
        } else {
            abort(403, 'Access denied');
        }
        
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileUpdateRequest $request)
    {
        $request->validated();

        $user = Auth::user();
        $data = collect($request->except(['profile_image']));

        if ($request->has('profile_image')) {
            $imageName = time() . '.' . $request->profile_image->extension();  
            $request->profile_image->move(public_path('img/uploads/'), $imageName);
            $data->put('profile_image', $imageName);

            if(File::exists(public_path('img/uploads/' . $user->profile_image)) && $user->profile_image != 'default-avatar.jpg'){
                File::delete(public_path('img/uploads/' . $user->profile_image));
            }
        }

        $user->update($data->toArray());

        return redirect()->route('profile.index')->with('success', 'Your profile has been updated!');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $entries = Timesheet::where('user_id', $id)
            ->select('id', 'date_from', 'date_to', 'time_from', 'time_to', 'break_in_minutes')
            ->orderBy('date_to', 'desc')
            ->limit(5)
            ->get();

        $supervisor = User::join('user_supervisors', 'users.id', '=', 'user_supervisors.supervisor_id')
            ->where('user_supervisors.user_id', $id)
            ->select('users.*')
            ->first();

        $entriesLength = Timesheet::where('user_id', $id)
            ->count();

        $overtimeObject = Overtime::where('user_id', $id)->first();
        if ($overtimeObject === null) {
            $overtime = 0;
        } else {
            $overtime = $overtimeObject->value;
        }

        foreach($entries as $entry) {
            $start = Carbon::parse($entry->time_from);
            $end = Carbon::parse($entry->time_to);

            $dateRegFrom = preg_replace('/\//', '.$2$1', $entry->date_from);
            $dateRegTo = preg_replace('/\//', '.$2$1', $entry->date_to);
            $datediff = strtotime($dateRegTo) - strtotime($dateRegFrom);
            $datediff = (int) round($datediff / (60 * 60 * 24)) + 1;

            $minutes = ($end->diffInMinutes($start) - $entry->break_in_minutes) * $datediff; 
            $hours = floor($minutes / 60);
            $minutes = ($minutes % 60);
            
            $entry->hours = sprintf('%02d', $hours) . 'h ' .sprintf('%02d', $minutes) . 'min'; 
        }

        return view('profile.show', compact('user', 'entries', 'entriesLength', 'overtime', 'supervisor'));
    }
}
