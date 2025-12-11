<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Users;

class Time_Punches extends Model
{
    protected $table = 'time_punches';

    protected $casts = [
        'recorded_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(Users::class);
    }
}
