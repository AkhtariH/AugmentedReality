<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entries = Holiday::orderBy('holiday_date', 'ASC')->get();

        return view('admin.holiday.index', compact('entries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.holiday.create');
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
            'name' => 'required',
            'holiday_date' => 'required',
        ]);

        $date = preg_replace('/\//', '/$2$1', $request->holiday_date);

        // Create new Timesheet
        Holiday::create([
            'name' => $request->name,
            'holiday_date' => $date,
        ]);

        return redirect()->route('admin.holiday.index')->with('success', 'Eintrag wurde erfolgreich übernommen!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function edit(Holiday $holiday)
    {
        return view('admin.holiday.edit', compact('holiday'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Holiday $holiday)
    {
        $request->validate([
            'name' => 'required',
            'holiday_date' => 'required',
        ]);

        $date = preg_replace('/\//', '.$2$1', $request->holiday_date);

        $holiday->update([
            'name' => $request->name,
            'holiday_date' => $date,
        ]);

        return redirect()->route('admin.holiday.index')->with('success', 'Eintrag wurde erfolgreich bearbeitet!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function destroy(Holiday $holiday)
    {
        $holiday->delete();

        return redirect()->route('admin.holiday.index')->with('success', 'Eintrag wurde erfolgreich gelöscht!');
    }
}
