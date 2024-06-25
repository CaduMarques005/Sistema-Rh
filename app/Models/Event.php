<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function Webmozart\Assert\Tests\StaticAnalysis\boolean;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'draft',

    ];

    protected function casts(): array
    {
        return [
            'draft' => 'boolean'
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

