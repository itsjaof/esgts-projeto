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

    protected $fillable = [
        'punch_type',
        'recorded_at',
        'lat',
        'lng',
        'accuracy_m',
        'formatted_address',
        'google_place_id',
        'raw_api_response',
        'ip_address',
    ];

    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }
}
