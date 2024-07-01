<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use DateTime;
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

    private function getWeekdaysDiff($start, $end)
    {
        $weekdays = 0;
        $currentDate = clone $start;

        while ($currentDate <= $end) {
            if ($currentDate->format('N') < 6) { // 1 (segunda-feira) a 5 (sexta-feira)
                $weekdays++;
            }
            $currentDate->modify('+1 day');
        }

        return $weekdays;
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'start' => 'required|date_format:Y-m-d H:i',
            'end' => 'required|date_format:Y-m-d H:i',
        ]);

        $start = \DateTime::createFromFormat('Y-m-d H:i', $validatedData['start']);
        $end = \DateTime::createFromFormat('Y-m-d H:i', $validatedData['end']);

        $interval = $start->diff($end);

        $hoursDifference = $interval->days * 8 + $interval->h;

        if ($interval->i > 0) {
            $hoursDifference += $interval->i / 60;
        }

        $user = User::where('id', Auth::id())->first();
        $userHours = $user->hours;

        $totalHours = $userHours - $hoursDifference;
        if ($user->hours < $hoursDifference) {
            return back()->with('denied', 'You dont have enough hours to request a vacation! :)');
        } else {

            $user->update([
                'hours' => $totalHours,
            ]);

            Event::create([
                'user_id' => Auth::id(),
                'user_name' => $user->name,
                'start' => $start,
                'end' => $end,
                'draft' => true,
            ]);

            $events = Event::query()->where('user_id', Auth::id())
                ->where('draft', false)->get();

            return back()->with('approve', 'Request sent successfully! :)');
        }

    }

    public function show()
    {
        $events = Event::query()->where('draft', true)->get();
        $usersIds = $events->pluck('user_id')->toArray();
        $users = User::whereIn('id', $usersIds)->get();

        return view('modules.requests.show', compact('events', 'users'));

    }

    public function approve($event_id)
    {
        $event = Event::find($event_id);

        if (! $event) {
            return response()->json(['message' => 'Evento não encontrado'], 404);
        }

        $event->update(['draft' => false]);

        return back()->with('approve', 'Request approved successfully! :)');
    }

    public function denied($event_id)
    {
        $event = Event::find($event_id);

        $start = new DateTime($event->start);
        $end = new DateTime($event->end);

        $interval = $start->diff($end);

        $hoursDifference = $interval->days * 8 + $interval->h;

        if ($interval->i > 0) {
            $hoursDifference += $interval->i / 60;
        }

        $user = User::find(Auth::id());

        $totalHours = $user->hours + $hoursDifference;

        $user->update(['hours' => $totalHours]);

        $event->update(['draft' => false]);

        $event->delete();

        return back()->with('denied', 'Request denied successfully! :)');
    }
}
