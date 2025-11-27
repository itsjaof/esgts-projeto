<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Time_Punches;

class Users extends Model
{
    protected $fillable = [
        'name',
        'email',
        'role',
        'position',
        'status',
        'google_id'
    ];

    protected $hidden = [
        'password',
    ];

    public function timePunches()
    {
        return $this->hasMany(Time_Punches::class);
    }

}
