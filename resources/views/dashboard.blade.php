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
                <p class="stat-value">150</p>
            </div>
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <h3>Empregados Ativos</h3>
                <p class="stat-value">100</p>
            </div>
            <div class="stat-icon">
                <i class="fas fa-user-check"></i>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <h3>Atrasos</h3>
                <p class="stat-value">8</p>
            </div>
            <div class="stat-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <h3>Em Pausa</h3>
                <p class="stat-value">10</p>
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
                <div class="map-placeholder">
                    <i class="fas fa-map fa-3x"></i>
                </div>
                <div class="map-footer">
                    <i class="fas fa-user-circle"></i>
                    <span>X empregados ativos</span>
                </div>
            </div>
        </div>

        <div class="activity-section">
            <h2>
                <i class="fas fa-history"></i> Atividade Recente
            </h2>
            <div class="activity-list">
                <div class="activity-item">
                    <div class="activity-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="activity-info">
                        <span class="activity-name">Nome</span>
                        <span class="activity-role">Cargo</span>
                    </div>
                    <span class="activity-time">
                        <i class="fas fa-clock"></i> Hora
                    </span>
                </div>
                <div class="activity-item">
                    <div class="activity-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="activity-info">
                        <span class="activity-name">Nome</span>
                        <span class="activity-role">Cargo</span>
                    </div>
                    <span class="activity-time">
                        <i class="fas fa-clock"></i> Hora
                    </span>
                </div>
                <div class="activity-item">
                    <div class="activity-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="activity-info">
                        <span class="activity-name">Nome</span>
                        <span class="activity-role">Cargo</span>
                    </div>
                    <span class="activity-time">
                        <i class="fas fa-clock"></i> Hora
                    </span>
                </div>
                <div class="activity-item">
                    <div class="activity-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="activity-info">
                        <span class="activity-name">Nome</span>
                        <span class="activity-role">Cargo</span>
                    </div>
                    <span class="activity-time">
                        <i class="fas fa-clock"></i> Hora
                    </span>
                </div>
                <div class="activity-item">
                    <div class="activity-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="activity-info">
                        <span class="activity-name">Nome</span>
                        <span class="activity-role">Cargo</span>
                    </div>
                    <span class="activity-time">
                        <i class="fas fa-clock"></i> Hora
                    </span>
                </div>
                <div class="activity-item">
                    <div class="activity-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="activity-info">
                        <span class="activity-name">Nome</span>
                        <span class="activity-role">Cargo</span>
                    </div>
                    <span class="activity-time">
                        <i class="fas fa-clock"></i> Hora
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
