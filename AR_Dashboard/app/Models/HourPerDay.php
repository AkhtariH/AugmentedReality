<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HourPerDay extends Model
{
    use HasFactory;

    protected $dates = [
        'date_from',
        'date_to'
    ];

    /*
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'date_from',
        'date_to',
        'hours_per_week',
    ];
}
