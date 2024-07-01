<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['required', 'min:10'],
            'position' => ['required', 'string', 'max:255'],
            'hours' => ['required', 'numeric'],
            'avatar' => ['nullable'],
        ]);

        if (request()->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $fileName = time().'-'.$avatar->getClientOriginalName();
            $avatar->storeAs('avatars', $fileName, 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => $fileName ?? null,
            'phone' => $request->phone,
            'hours' => $request->hours,
            'position' => $request->position,
        ]);

        event(new Registered($user));

        // Auth::login($user);

        return redirect(route('users.index', absolute: false))->with('message', 'User registered with successfully! :)');
    }
}
