<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'entry_time',
        'departure_time',
        'total_hours',
        'project1_name',
        'project1_hours',
        'project2_name',
        'project2_hours',
        'project3_name',
        'project3_hours',
        'project4_name',
        'project4_hours',
        'project5_name',
        'project5_hours',
        'project6_name',
        'project6_hours',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
