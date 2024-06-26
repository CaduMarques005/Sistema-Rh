<?php

use App\Models\User;

if (! function_exists('example_helper')) {
    function userCount()
    {
        return User::all()->count();
    }
}
