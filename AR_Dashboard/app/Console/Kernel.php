<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Holiday;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            Holiday::truncate();
            $currYear = date('Y');
            $response = Http::withHeaders([
                'X-DFA-Token' => 'dfa',
            ])->post('https://deutsche-feiertage-api.de/api/v1/' . $currYear . '?bundeslaender=nw');
            $holidaysArr = $response->json()['holidays'];
            foreach($holidaysArr as $holiday) {
                $holidayData = $holiday['holiday'];
                Holiday::create([
                    'name' => $holidayData['name'],
                    'holiday_date' => $holidayData['date']
                ]);
            }
        })->yearly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
