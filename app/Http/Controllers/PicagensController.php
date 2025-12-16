<?php

namespace App\Http\Controllers;

use App\Models\Time_Punches;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PicagensController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        $picagens = $this->picagensByDate($date);

        return view('picagens', [
            'selectedDate' => $date,
            'picagens' => $picagens,
        ]);
    }

    public function data(Request $request)
    {
        $date = $request->query('date', now()->toDateString());
        $picagens = $this->picagensByDate($date);

        return response()->json([
            'data' => $picagens,
        ]);
    }

    public function store(Request $request)
    {
        $sessionUser = session('user');

        if (!$sessionUser) {
            return response()->json([
                'message' => 'Não autenticado.',
            ], 401);
        }

        $data = $request->validate([
            'punch_type' => 'required|in:entrada,saida,pausa_inicio,pausa_fim',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'accuracy_m' => 'nullable|numeric',
        ]);

        $user = Users::find($sessionUser['id']);

        if (!$user) {
            return response()->json([
                'message' => 'Utilizador não encontrado.',
            ], 404);
        }

        $punch = $user->timePunches()->create([
            ...$data,
            'recorded_at' => now(),
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'message' => 'Picagem registada com sucesso.',
            'data' => $punch->load('user'),
        ], 201);
    }

    public function latest(Request $request)
    {
        $limit = (int) $request->query('limit', 50);

        // Última picagem por utilizador
        $latestPerUser = Time_Punches::select('time_punches.*')
            ->join(DB::raw('(SELECT user_id, MAX(recorded_at) AS latest FROM time_punches GROUP BY user_id) lp'), function ($join) {
                $join->on('time_punches.user_id', '=', 'lp.user_id')
                    ->on('time_punches.recorded_at', '=', 'lp.latest');
            })
            ->with('user')
            ->latest('recorded_at')
            ->limit($limit)
            ->get();

        return response()->json([
            'data' => $latestPerUser->map(function ($punch) {
                return [
                    'id' => $punch->id,
                    'name' => $punch->user?->name,
                    'position' => $punch->user?->position,
                    'punch_type' => $punch->punch_type,
                    'recorded_at' => optional($punch->recorded_at)->toDateTimeString(),
                    'lat' => $punch->lat,
                    'lng' => $punch->lng,
                ];
            }),
        ]);
    }

    private function picagensByDate(string $date)
    {
        $records = Time_Punches::with('user')
            ->whereDate('recorded_at', $date)
            ->orderBy('recorded_at')
            ->get();

        return $records
            ->groupBy('user_id')
            ->map(function ($group) {
                $entrada = $group->firstWhere('punch_type', 'entrada');
                $saida = $group->last(function ($punch) {
                    return $punch->punch_type === 'saida';
                });
                $pausaInicio = $group->firstWhere('punch_type', 'pausa_inicio');
                $pausaFim = $group->last(function ($punch) {
                    return $punch->punch_type === 'pausa_fim';
                });

                $user = $group->first()->user;

                return [
                    'nome' => $user?->name ?? 'Sem nome',
                    'hora_entrada' => $entrada?->recorded_at?->format('H:i'),
                    'hora_saida' => $saida?->recorded_at?->format('H:i'),
                    'hora_pausa_inicio' => $pausaInicio?->recorded_at?->format('H:i'),
                    'hora_pausa_fim' => $pausaFim?->recorded_at?->format('H:i'),
                    'status' => $saida ? 'Completo' : 'Pendente',
                ];
            })
            ->values();
    }
}

