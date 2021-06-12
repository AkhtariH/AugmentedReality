<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Timesheet;
use App\Models\HourPerDay;
use App\Models\Overtime;

use App\Events\ThresholdExceeded;
use Carbon\Carbon;

class DateFilterController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function search(Request $request) {
        $request->validate([
            'date_from' => 'required',
            'date_to' => 'required'
        ]);

        $dateRegFrom = preg_replace('/\//', '.$2$1', $request->date_from);
        $dateRegTo = preg_replace('/\//', '.$2$1', $request->date_to);
        $dateFrom = date_format(new \DateTime($dateRegFrom), 'Y-m-d');
        $dateTo = date_format(new \DateTime($dateRegTo), 'Y-m-d');

        $entries = Timesheet::where([
                ['user_id', '=', Auth()->user()->id],
                ['date_from', '>=', $dateFrom],
                ['date_from', '<=', $dateTo]
            ])
            ->select('id', 'date_from', 'date_to', 'time_from', 'time_to', 'break_in_minutes')
            ->paginate(5);
        

        $latestEntryDate = Timesheet::where('user_id', Auth()->user()->id)
        ->orderBy('date_to', 'desc')
        ->first();

        foreach($entries as $entry) {
            $start = Carbon::parse($entry->time_from);
            $end = Carbon::parse($entry->time_to);
            $entry->hours = ($end->diffInMinutes($start)) - $entry->break_in_minutes;          
        }

        $overtimeObject = Overtime::where('user_id', Auth()->user()->id)->first();
        if ($overtimeObject === null) {
            $overtime = 0;
        } else {
            $overtime = $overtimeObject->value;
        }

        return view('dashboard.index', compact('entries', 'overtime', 'latestEntryDate'));
    }
}
