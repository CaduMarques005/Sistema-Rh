<?php

use App\Models\Event;
use App\Models\User;

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
