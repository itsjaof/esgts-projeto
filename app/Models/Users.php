<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Models\Time_Punches;

class Users extends Model
{

    /*
     * Select for the first grid on dashboard
     */
    public static function dashboardElements()
    {
        return DB::selectOne("SELECT

                                -- TOTAL USERS
                                (
                                    SELECT COUNT(*)
                                    FROM users
                                ) AS total_users,

                                -- USERS ACTIVE
                                (
                                    SELECT COUNT(*)
                                    FROM users u
                                    WHERE u.status = 'ativo'
                                ) AS actives,

                                -- USERS IN PAUSE
                                (
                                    SELECT COUNT(*)
                                    FROM time_punches t
                                    WHERE t.punch_type = 'pausa_inicio'
                                    AND user_id NOT IN (
                                        SELECT user_id
                                        FROM time_punches
                                        WHERE punch_type = 'pausa_fim'
                                    )
                                ) AS pauses
                            ");
    }

    /*
     * Select for the grid at recently activities
     */
    public static function recentlyActivities()
    {
        return DB::select("SELECT CONCAT(TIME(t.recorded_at)) AS recorded_at,
                                    u.`name` AS `name`,
                                    u.`position` AS position,
                                    t.punch_type AS punch_type
                            FROM time_punches t
                            JOIN users u ON t.user_id = u.id
                            ORDER BY t.recorded_at DESC
                            LIMIT 6
                        ");
    }


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
