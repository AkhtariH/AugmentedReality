<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Timesheet;
use App\Models\HourPerDay;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;

use Carbon\Carbon;

use App\Events\NewUserRegistered;

class UserController extends Controller
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
        $employees = User::where('type', 'employee')->latest()->get();
        $admins = User::where('type', 'admin')->latest()->get();

        return view('admin.user.index', compact('employees', 'admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $request->validated();

        $data = $request->all();

        $check = User::create($data);

        // event(new NewUserRegistered($check));

        return redirect()->route('admin.user.index')->with('success', 'Benutzer wurde erfolgreich angelegt!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $supervisors = User::select('first_name', 'last_name')->get();
        $supervisorsArr = [];
        foreach ($supervisors as $supervisor) {
            array_push($supervisorsArr, $supervisor->first_name . ' ' . $supervisor->last_name);
        }

        $supervisor = User::join('user_supervisors', 'users.id', '=', 'user_supervisors.supervisor_id')
            ->where('user_supervisors.user_id', $id)
            ->first();
        $entries = Timesheet::where('user_id', $id)
            ->orderBy('date_to', 'desc')
            ->get();

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

        $latestEntryDate = Timesheet::where('user_id', Auth()->user()->id)
        ->orderBy('date_to', 'desc')
        ->first();

        $overtime = null;
        $hpd = HourPerDay::where([
            ['user_id', '=', $id],
            ['date_from', '<=', $latestEntryDate->date_from],
            ['date_to', '>=', $latestEntryDate->date_from]
        ])
        ->select('hour_per_days.*')
        ->first();
        $overtimeObj = $this->getOvertime($hpd);
        if ($overtimeObj->result > $overtimeObj->minutes) {
            $overtime = round(($overtimeObj->result - $overtimeObj->minutes) / 60);
        }

        return view('admin.user.show', compact('user', 'entries', 'overtime', 'supervisorsArr', 'supervisor'));
    }

    public function getOvertime($hpd) {
        // Max hours to minutes
        $minutes = ($hpd->hours_per_week * 60);

        // Get the number of weeks user has already filled in
        $earliestEntry = Timesheet::where([
            ['hour_per_day_id', $hpd->id]
        ])->orderBy('date_from','asc')->first();
        $latestEntry = Timesheet::where([
            ['hour_per_day_id', $hpd->id],
        ])->orderBy('date_to','desc')->first();

        $startDate = Carbon::parse($earliestEntry->date_from)->startOfWeek();
        $endDate = Carbon::parse($latestEntry->date_to)->endOfWeek();
        $diff_in_weeks = $startDate->diffInWeeks($endDate) + 1;
        $minutes = $minutes * $diff_in_weeks;

        // Get the hours the user has alreeady filled in
        $timesheets = Timesheet::where('hour_per_day_id', $hpd->id)->get();
        $result = 0;
        foreach ($timesheets as $timesheet) {
            $datediff = strtotime($timesheet->date_to) - strtotime($timesheet->date_from); //strtotime($dateRegTo) - strtotime($dateRegFrom);
            $datediff = (int) round($datediff / (60 * 60 * 24)) + 1;
            
            $start = Carbon::parse($timesheet->time_from);
            $end = Carbon::parse($timesheet->time_to);
            $working_hour = (($end->diffInMinutes($start)) - $timesheet->break_in_minutes) * $datediff; // Arbeitszeit

            $result += $working_hour;
        }

        $resultObj = new \stdClass;
        $resultObj->minutes = $minutes;
        $resultObj->result = $result;

        return $resultObj;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $request->validated();

        $data = $request->except('password');
        if ($request->has('password') && $request->password != '') {
            $data = $request->all();
            $data['password'] = Hash::make($data['password']);
        }

        $user = User::findOrFail($id);
        $user->update($data);

        return redirect()->route('admin.user.index')->with('success', 'User has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.user.index')->with('success', 'User has been deleted!');
    }
}
