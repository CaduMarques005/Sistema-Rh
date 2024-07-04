<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {

        if (strlen($this->search) > 0) {
            $users = User::where('name', 'like', '%'.$this->search.'%')->paginate(8);

        } else {
            $users = User::paginate(5);
        }

        return view('livewire.users', [
            'users' => $users,
        ]);
    }
}
