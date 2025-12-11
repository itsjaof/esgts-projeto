<?php

namespace App\Http\Controllers;

use App\Models\Time_Punches;
use Illuminate\Http\Request;

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

