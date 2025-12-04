<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public static function num_pausas(){

        return DB::table('time_punches')
                ->where('punch_type', 'pausa_inicio')
                ->whereNotIn('user_id', function ($query) {
                    $query->select('user_id')
                        ->from('time_punches')
                        ->where('punch_type', 'pausa_fim');
                })
                ->count();
    }

    public static function atividade_recente(){

        return DB::select('SELECT CONCAT(TIME(t.recorded_at)) AS recorded_at,
                                    u.`name` AS nome_user,
                                    u.`position` AS cargo,
                                    t.punch_type AS tipo
                            FROM time_punches t
                            JOIN users u ON t.user_id = u.id
                            ORDER BY t.recorded_at DESC
                            LIMIT 6');
    }



}
