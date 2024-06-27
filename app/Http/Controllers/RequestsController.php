<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;

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

        // Converte as strings para objetos DateTime
        $start = \DateTime::createFromFormat('Y-m-d H:i', $validatedData['start']);
        $end = \DateTime::createFromFormat('Y-m-d H:i', $validatedData['end']);

        // Calcula a diferença entre as datas
        $interval = $start->diff($end);

        // Conta cada dia como 8 horas
        $hoursDifference = $interval->days * 8 + $interval->h;

        // Se houver minutos na diferença, os adiciona como uma fração de hora
        if ($interval->i > 0) {
            $hoursDifference += $interval->i / 60;
        }

        // Recupera o usuário atual
        $user = User::where('id', Auth::id())->first();
        $userHours = $user->hours;

        // Calcula o total de horas restantes
        $totalHours = $userHours - $hoursDifference;

        // Atualiza as horas do usuário
        $user->update([
            'hours' => $totalHours,
        ]);

        // Recupera os eventos e os usuários associados
        $events = Event::query()
            ->where('draft', false)->get();
        $usersIds = $events->pluck('user_id')->unique();
        $users = User::query()->whereIn('id', $usersIds)->get();

        return view('modules.calendar.index', compact('events', 'users'));
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

        return back();
    }

    public function denied($event_id)
    {
        $event = Event::find($event_id);

        if (! $event) {
            return redirect()->back(['message' => 'Event not found! :('], 404);
        }

        $event->delete();

        return back();
    }
}
