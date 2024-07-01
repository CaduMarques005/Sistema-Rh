<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserRequests extends Controller
{
    public function all()
    {
        $events = DB::table('events')
            ->where('user_id', Auth::user()->id)
            ->paginate(8);

        $users = DB::table('users')->where('id', auth()->id())->get();

        return view('modules.myRequests.all', compact('events', 'users'));

    }

    public function canceled()
    {
        $events = DB::table('events')
            ->where('user_id', Auth::user()->id)
            ->where('draft', false)
            ->paginate(8);

        $users = DB::table('users')->where('id', auth()->id())->get();

        return view('modules.myRequests.all', compact('events', 'users'));

    }

    public function approved()
    {
        $events = DB::table('events')
            ->where('user_id', Auth::user()->id)
            ->where('draft', true)
            ->paginate(8);

        $users = DB::table('users')->where('id', auth()->id())->get();

        return view('modules.myRequests.approved', compact('events', 'users'));

    }

    public function pending()
    {
        $events = DB::table('events')
            ->where('user_id', Auth::user()->id)
            ->where('draft', true)
            ->paginate(8);

        $users = DB::table('users')->where('id', auth()->id())->get();

        return view('modules.myRequests.pending', compact('events', 'users'));
    }
}
