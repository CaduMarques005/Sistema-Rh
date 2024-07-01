<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserRequests extends Controller
{
    public function all()
    {
        $events = DB::table('events')
            ->where('user_id', Auth::user()->id)->paginate(8);

        return view('modules.myRequests.all', compact('events'));

    }
}
