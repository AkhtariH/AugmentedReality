<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Timesheet;
use App\Models\HourPerDay;
use App\Models\Overtime;
use App\Models\EntryType;
use App\Models\Holiday;

use App\Events\ThresholdExceeded;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $entries = Timesheet::where('user_id', Auth()->user()->id)
            ->select('id', 'date_from', 'date_to', 'time_from', 'time_to', 'break_in_minutes', 'entry_type_id')
            ->orderBy('date_to', 'desc')
            ->get();

        $latestEntryDate = Timesheet::where('user_id', Auth()->user()->id)
            ->orderBy('date_to', 'desc')
            ->first();

        $supervisor = User::join('user_supervisors', 'users.id', '=', 'user_supervisors.supervisor_id')
            ->where('user_supervisors.user_id', Auth()->user()->id)
            ->first();

        $holidays = Holiday::all();

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


        $overtime = null;
        $hours_per_week = null;
        if ($latestEntryDate != null) {
            $hpd = HourPerDay::where([
                ['user_id', '=', Auth()->user()->id],
                ['date_from', '<=', $latestEntryDate->date_from],
                ['date_to', '>=', $latestEntryDate->date_from]
            ])
            ->select('hour_per_days.*')
            ->first();
            $hours_per_week = $hpd->hours_per_week;
    
            $overtimeObj = $this->getOvertime($hpd);

            if ($overtimeObj->result > $overtimeObj->minutes) {
                $result = $overtimeObj->result - $overtimeObj->minutes;
                $overtime = round($result / 60);
            }
        }
        $hours_per_day = round($hours_per_week / 5);

        return view('dashboard.index', compact('entries', 'overtime', 'latestEntryDate', 'supervisor', 'holidays', 'hours_per_day'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entry = Timesheet::findOrFail($id);
        $hpd = HourPerDay::findOrFail($entry->hour_per_day_id);

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

        if ($entry->edit_from !== null) {
            $edit_from_name = User::where('id', $entry->edit_from)->first();
            $entry->edit_from_name = $edit_from_name->first_name . ' ' . $edit_from_name->last_name;
        } else {
            $entry->edit_from_name = '';
        }

        if ($entry->updated_at != $entry->created_at) {
            $entry->edit_update = $entry->updated_at;
        } else {
            $entry->edit_update = '';
        }
        
        
        return view('dashboard.show', compact('entry', 'hpd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newDateTime = Carbon::now()->addMonth()->toDateString();
        
        $request->validate([
            'date_from' => 'required|before:' . $newDateTime,
            'date_to' => 'required|before:' . $newDateTime,
            'time_from' => 'required',
            'time_to' => 'required',
            'break_in_minutes' => 'required',
            'hpd_id' => 'required',
            'entry_type' => 'required'
        ]);
        $dateRegFrom = preg_replace('/\//', '.$2$1', $request->date_from);
        $dateRegTo = preg_replace('/\//', '.$2$1', $request->date_to);

        $entryTypeID = EntryType::where('type', $request->entry_type)->first();
        
        // Create new Timesheet
        Timesheet::create([
            'user_id' => Auth()->user()->id,
            'hour_per_day_id' => (int) $request->hpd_id,
            'date_from' => $dateRegFrom,
            'date_to' => $dateRegTo,
            'time_from' => $request->time_from,
            'time_to' => $request->time_to,
            'break_in_minutes' => $request->break_in_minutes,
            'entry_type_id' => $entryTypeID->id
        ]);

        // Get HPD entry thats within the date range
        $date = date_format(new \DateTime($dateRegFrom), 'Y-m-d');
        $hpd = HourPerDay::where([
                ['user_id', '=', Auth()->user()->id],
                ['date_from', '<=', $date],
                ['date_to', '>=', $date]
            ])
            ->select('hour_per_days.*')
            ->first();


        $overtimeData = round(($overtimeObj->result - $overtimeObj->minutes) / 60);

        if ($overtimeObj->result > $overtimeObj->minutes && Auth()->user()->overtime_email == 1 && Auth()->user()->max_overtime >= $overtimeData) {
            $supervisor = User::join('user_supervisors', 'users.id', '=', 'user_supervisors.supervisor_id')
                ->where('user_supervisors.user_id', Auth()->user()->id)
                ->first();

            $overtimeData = new \stdClass;
            $overtimeData->hours_per_week = round($overtimeObj->minutes / 60);
            $overtimeData->totalTime = round($overtimeObj->result / 60);
            $overtimeData->overtime = round(($overtimeObj->result - $overtimeObj->minutes) / 60);
            $overtimeData->name = Auth()->user()->username;
            $overtimeData->supervisor_email = $supervisor->email;

            event(new ThresholdExceeded($overtimeData));
        }



        return redirect()->route('dashboard.index')->with('success', 'Eintrag wurde erfolgreich übernommen!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $entry = Timesheet::findOrFail($id);
        $hpd = HourPerDay::findOrFail($entry->hour_per_day_id);

        return view('dashboard.edit', compact('entry', 'hpd'));
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
        $newDateTime = Carbon::now()->addMonth()->toDateString();

        $request->validate([
            'date_from' => 'required|before:' . $newDateTime,
            'date_to' => 'required|before:' . $newDateTime,
            'time_from' => 'required',
            'time_to' => 'required',
            'break_in_minutes' => 'required',
            'hour_per_day_id' => 'required',
            'edit_reason' => 'required',
            'entry_type_id' => 'required'
        ]);

        $data = $request->all();
        $data['edit_from'] = Auth()->user()->id;
        $data['date_from'] = preg_replace('/\//', '.$2$1', $request->date_from);
        $data['date_to'] = preg_replace('/\//', '.$2$1', $request->date_to);
        $data['entry_type_id'] = EntryType::where('type', $request->entry_type_id)->first()->id;
        $timesheet = Timesheet::findOrFail($id);
        $timesheet->update($data);

        // Get HPD entry thats within the date range
        $dateRegFrom = preg_replace('/\//', '.$2$1', $request->date_from);
        $date = date_format(new \DateTime($dateRegFrom), 'Y-m-d');
        $hpd = HourPerDay::where([
                ['user_id', '=', Auth()->user()->id],
                ['date_from', '<=', $date],
                ['date_to', '>=', $date]
            ])
            ->select('hour_per_days.*')
            ->first();


        $overtimeObj = $this->getOvertime($hpd);
        $overtimeData = round(($overtimeObj->result - $overtimeObj->minutes) / 60);

        if ($overtimeObj->result > $overtimeObj->minutes && Auth()->user()->overtime_email == 1 && Auth()->user()->max_overtime >= $overtimeData) {
            $supervisor = User::join('user_supervisors', 'users.id', '=', 'user_supervisors.supervisor_id')
                ->where('user_supervisors.user_id', Auth()->user()->id)
                ->first();

            $overtimeData = new \stdClass;
            $overtimeData->hours_per_week = round($overtimeObj->minutes / 60);
            $overtimeData->totalTime = round($overtimeObj->result / 60);
            $overtimeData->overtime = round(($overtimeObj->result - $overtimeObj->minutes) / 60);
            $overtimeData->name = Auth()->user()->username;
            $overtimeData->supervisor_email = $supervisor->email;

            event(new ThresholdExceeded($overtimeData));
        }


        return redirect()->route('dashboard.index')->with('success', 'Eintrag wurde erfolgreich bearbeitet!');
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

    public function getHPD(Request $request) {
        $request->validate([
            'date_from' => 'required',
            'date_to' => 'required'
        ]);
        $dateRegFrom = preg_replace('/\//', '.$2$1', $request->date_from);
        $dateRegTo = preg_replace('/\//', '.$2$1', $request->date_to);
        $date = date_format(new \DateTime($dateRegFrom), 'Y-m-d');
        $date2 = date_format(new \DateTime($dateRegTo), 'Y-m-d');
        $hpd = HourPerDay::where([
                ['user_id', '=', Auth()->user()->id],
                ['hour_per_days.date_from', '<=', $date],
                ['hour_per_days.date_to', '>=', $date],
                ['hour_per_days.date_from', '<=', $date2],
                ['hour_per_days.date_to', '>=', $date2],
            ])
            ->select('hour_per_days.*')
            ->first();

        $result = '';
        if ($hpd === null) {
            $result = '-';
        } else {
            $result = array($hpd->hours_per_week, $hpd->id);
        }
        
        return response()->json($result, 200);       
    }
}
