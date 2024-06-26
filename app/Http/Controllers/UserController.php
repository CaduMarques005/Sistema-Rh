<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;



class UserController extends Controller
{

    public function index()
    {


        return view('modules.users.index', ['users' => User::query()
            ->when(request('search'), function (Builder $query) {
            $query->where('name', 'like', '%' . request('search') . '%');
        })
            ->paginate(5)

        ]);
    }
}
