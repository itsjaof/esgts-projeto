@extends('layouts.app')

@section('title', 'PointSystem - Picagens')

@section('content')
<div class="main-content">
        <div class="content-header">
            <h1>Registos de Picagens</h1>
            <p class="subtitle">Visualizar e gerir as entradas e saídas dos empregados.</p>
        </div>

        <div class="picagens-layout">
            <div class="calendar-section">
                <h2>
                    <i class="fas fa-calendar-alt"></i> Calendário
                </h2>
                <div class="calendar-container">
                    <div class="calendar-header">
                        <button class="calendar-nav-btn" id="prevMonth">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <div class="calendar-month-year" id="currentMonthYear"></div>
                        <button class="calendar-nav-btn" id="nextMonth">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    <div class="calendar-weekdays">
                        <div class="calendar-weekday">Dom</div>
                        <div class="calendar-weekday">Seg</div>
                        <div class="calendar-weekday">Ter</div>
                        <div class="calendar-weekday">Qua</div>
                        <div class="calendar-weekday">Qui</div>
                        <div class="calendar-weekday">Sex</div>
                        <div class="calendar-weekday">Sáb</div>
                    </div>
                    <div class="calendar-days" id="calendarDays"></div>
                </div>
            </div>

            <div class="picagens-list-section">
                <h2>
                    <i class="fas fa-clock"></i> Picagens
                </h2>
                <div class="picagens-list" id="picagensList">
                    @php
                        $initialPicagens = $picagens ?? [];
                    @endphp

                    @forelse ($initialPicagens as $picagem)
                        @php
                            $status = $picagem['status'] ?? 'Pendente';
                            $statusLower = strtolower($status);
                            $statusClass = '';

                            if (str_contains($statusLower, 'completo') || str_contains($statusLower, 'concluído')) {
                                $statusClass = 'status-complete';
                            } elseif (str_contains($statusLower, 'pendente')) {
                                $statusClass = 'status-pending';
                            } elseif (str_contains($statusLower, 'atraso')) {
                                $statusClass = 'status-late';
                            }
                        @endphp

                        <div class="picagem-card">
                            <div class="picagem-info">
                                <div class="picagem-name">{{ $picagem['nome'] ?? 'Nome' }}</div>
                                <div class="picagem-times">
                                    <span class="picagem-time">
                                        <i class="fas fa-sign-in-alt"></i> {{ $picagem['hora_entrada'] ?? '--:--' }}
                                    </span>
                                <span class="picagem-time">
                                    <i class="fas fa-coffee"></i> {{ $picagem['hora_pausa_inicio'] ?? '--:--' }}
                                </span>
                                <span class="picagem-time">
                                    <i class="fas fa-play-circle"></i> {{ $picagem['hora_pausa_fim'] ?? '--:--' }}
                                </span>
                                    <span class="picagem-time">
                                        <i class="fas fa-sign-out-alt"></i> {{ $picagem['hora_saida'] ?? '--:--' }}
                                    </span>
                                </div>
                            </div>
                            <span class="picagem-status {{ $statusClass }}">{{ $status }}</span>
                        </div>
                    @empty
                        <div style="text-align: center; padding: 40px; color: var(--color-text-secondary);">
                            <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 12px; opacity: 0.3;"></i>
                            <p>Nenhuma picagem registada para este dia.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
