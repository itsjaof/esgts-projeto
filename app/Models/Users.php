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
                                    AND DATE(t.recorded_at) = CURDATE()
                                    AND NOT EXISTS (
                                        SELECT 1
                                        FROM time_punches t2
                                        WHERE t2.user_id = t.user_id
                                            AND t2.punch_type = 'pausa_fim'
                                            AND DATE(t2.recorded_at) = CURDATE()
                                    )

                                ) AS pauses,

                                -- USERS IN WORK
                                (
                                    SELECT COUNT(*)
                                    FROM time_punches t
                                    WHERE t.punch_type = 'entrada'
                                    AND DATE(t.recorded_at) = CURDATE()
                                    AND NOT EXISTS (
                                        SELECT 1
                                        FROM time_punches t2
                                        WHERE t2.user_id = t.user_id
                                            AND t2.punch_type IN ('pausa_inicio', 'pausa_fim', 'saida')
                                            AND DATE(t2.recorded_at) = CURDATE()
                                    )
                                    
                                ) AS worked
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
        return $this->hasMany(Time_Punches::class, 'user_id');
    }
}
