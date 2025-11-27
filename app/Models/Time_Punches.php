<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Users;

class Time_Punches extends Model
{
    public function user()
    {
        return $this->belongsTo(Users::class);
    }
}
