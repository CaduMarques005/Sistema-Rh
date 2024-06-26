<?php

use App\Models\User;
use App\Models\Event;

if (! function_exists('example_helper')) {
    function userCount()
    {
        return User::all()->count();
    }

    function requestsCount()
    {
        return Event::where('draft', true)->count();
    }


}
