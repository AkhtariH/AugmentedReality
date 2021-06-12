<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HourPerDay;
use App\Models\User;

class HpdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entries = HourPerDay::orderBy('user_id', 'asc')->get();
        foreach ($entries as $entry) {
            $user = User::find($entry->user_id);
            $entry->user_name = $user->first_name . ' ' . $user->last_name;
        }

        return view('admin.hpd.index', compact('entries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::select('username')->get();
        $userArr = [];
        foreach ($users as $user) {
            array_push($userArr, $user->username);
        }

        return view('admin.hpd.create', compact('userArr'));
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
            'username' => 'required',
            'hours_per_week' => 'required',
            'date_from' => 'required',
            'date_to' => 'required'
        ]);

        $user = User::where('username', $request->username)->first();
        $dateRegFrom = preg_replace('/\//', '.$2$1', $request->date_from);
        $dateRegTo = preg_replace('/\//', '.$2$1', $request->date_to);
        

        // Create new Timesheet
        HourPerDay::create([
            'user_id' => $user->id,
            'date_from' => $dateRegFrom,
            'date_to' => $dateRegTo,
            'hours_per_week' => $request->hours_per_week
        ]);

        return redirect()->route('admin.hpd.index')->with('success', 'Eintrag wurde erfolgreich übernommen!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $entry = HourPerDay::findOrFail($id);
        $dbUser = User::find($entry->user_id);
        $users = User::select('username')->get();

        $userArr = [];
        foreach ($users as $user) {
            array_push($userArr, $user->username);
        }
        return view('admin.hpd.edit', compact('entry', 'userArr', 'dbUser'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required',
            'hours_per_week' => 'required',
            'date_from' => 'required',
            'date_to' => 'required'
        ]);

        $dateFrom = preg_replace('/\//', '.$2$1', $request->date_from);
        $dateTo = preg_replace('/\//', '.$2$1', $request->date_to);

        $hpd = HourPerDay::findOrFail($id);
        $hpd->update([
            'username' => $request->username,
            'hours_per_week' => $request->hours_per_week,
            'date_from' => $dateFrom,
            'date_to' => $dateTo
        ]);

        return redirect()->route('admin.hpd.index')->with('success', 'Eintrag wurde erfolgreich bearbeitet!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hpd = HourPerDay::findOrFail($id);
        $hpd->delete();

        return redirect()->route('admin.hpd.index')->with('success', 'Eintrag wurde erfolgreich gelöscht!');
    }
}
