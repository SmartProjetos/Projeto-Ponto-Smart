<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faltas extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'all_day',
        'total_hours',
        'observation',
        'arquive',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
