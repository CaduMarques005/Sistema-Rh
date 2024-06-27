<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
        'start',
        'end',
        'draft',

    ];

    protected function casts(): array
    {
        return [
            'draft' => 'boolean',

        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
