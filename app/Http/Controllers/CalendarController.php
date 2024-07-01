<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

    public function userCalendar()
    {
        $events = Event::query()->where('user_id', Auth::id())
            ->where('draft', false)->get();

        return view('modules.calendar.show', compact('events'));
    }
}
