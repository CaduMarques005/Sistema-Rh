<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;

class CalendarController extends Controller
{
    public function calendar()
    {
        $events = Event::query()
            ->where('draft', false)->get();
        $usersIds = $events->pluck('user_id')->unique();

        $users = User::query()->whereIn('id', $usersIds)->get();

        return view('modules.calendar.index', compact('events'), compact('users'));
    }
}
