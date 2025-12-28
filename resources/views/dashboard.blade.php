@extends('layouts.app')

@section('title', 'PointSystem - Dashboard')

@section('content')

<div class="main-content">
<div class="content-header">
        <h1>Dashboard</h1>
        <p class="subtitle">Visão geral do sistema de picagem</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-info">
                <h3>Total Empregados</h3>
                <p class="stat-value">{{$elements->total_users}}</p>
            </div>
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <h3>Empregados Ativos</h3>
                <p class="stat-value">{{$elements->actives}}</p>
            </div>
            <div class="stat-icon">
                <i class="fas fa-user-check"></i>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <h3>Em Trabalho</h3>
                <p class="stat-value">{{$elements->worked}}</p>
            </div>
            <div class="stat-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <h3>Em Pausa</h3>
                <p class="stat-value">{{$elements->pauses}}</p>
            </div>
            <div class="stat-icon">
                <i class="fas fa-coffee"></i>
            </div>
        </div>
    </div>

    <div class="content-grid">
        <div class="map-section">
            <h2>
                <i class="fas fa-map-marked-alt"></i> Geolocalização em Tempo Real
            </h2>
            <div class="map-container">
                <div class="map-placeholder" id="map">

                </div>
                <div class="map-footer">
                    <i class="fas fa-user-circle"></i>
                    <span>{{$elements->actives}} empregados ativos</span>
                </div>
            </div>
        </div>

        <div class="activity-section">
            <h2>
                <i class="fas fa-history"></i> Atividade Recente
            </h2>
            <div class="activity-list">
                @foreach ($activities as $activity)
                    <div class="activity-item">
                        <div class="activity-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="activity-info">
                            <span class="activity-name">{{$activity->name}}</span>
                            <span class="activity-role">{{$activity->position}}</span>
                        </div>
                        @if ($activity->punch_type == 'entrada')
                            <span class="activity-time" style="color: rgb(0, 253, 0)">
                                <i class="fas fa-clock"></i> {{$activity->recorded_at}}
                            </span>
                        @elseif (str_contains($activity->punch_type, 'pausa'))
                            <span class="activity-time" style="color: rgb(250, 250, 4)">
                            <i class="fas fa-clock"></i> {{$activity->recorded_at}}
                            </span>
                        @elseif ($activity->punch_type == 'saida')
                            <span class="activity-time" style="color: red">
                            <i class="fas fa-clock"></i> {{$activity->recorded_at}}
                            </span>
                        @endif
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</div>
@endsection

