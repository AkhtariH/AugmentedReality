<?php

namespace App\Traits;

trait Trackable
{
    public static function bootTrackable()
    {
        static::created(function ($model) {
            // if () {

            // }
        });


    }

}