<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    use HasFactory;

    protected $dates = [
        'date_from',
        'date_to',
        'time_from',
        'time_to'
    ];

    protected $date = [

    ];

    /*
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'hour_per_day_id',
        'entry_type_id',
        'date_from',
        'date_to',
        'time_from',
        'time_to',
        'break_in_minutes',
        'edit_from',
        'edit_reason'
    ];
}
