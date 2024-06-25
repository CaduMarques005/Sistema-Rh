<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestsController extends Controller
{
    public function index()
    {
        return view('modules.requests.index');
    }

    public function create()
    {
        return view('modules.requests.create');
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'start_date' => 'required|date_format:m/d/Y',
            'end_date' => 'required|date_format:m/d/Y',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
        ]);

        $start_date = \DateTime::createFromFormat('m/d/Y', $validatedData['start_date'])->format('Y-m-d');
        $end_date = \DateTime::createFromFormat('m/d/Y', $validatedData['end_date'])->format('Y-m-d');

        $request = Event::create([
            'start_date' => $start_date,
            'end_date' => $end_date,
            'start_time' => $validatedData['start_time'],
            'end_time' => $validatedData['end_time'],
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
        ]);

        return back();
    }
}
