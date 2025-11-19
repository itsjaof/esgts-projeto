@extends('layouts.app')

@section('title', 'PointSystem - Registo')

@section('content')
<div class="main-content">
        <div class="content-header">
            <h1>Registar Picagem</h1>
            <p class="subtitle">Aqui poderá registar a sua entrada ou saída.</p>
        </div>

        <div class="picagem-container">
            <div class="time-display-card">
                <div class="date-display" id="date-display">Sexta-Feira, 3 de Outubro de 2025</div>
                <div class="time-display" id="time-display">12:12:12</div>
                <div class="location-display">
                    <i class="fas fa-map-marker-alt"></i> <span id="location-text">Localização desconhecida.</span>
                </div>
            </div>

            <div class="status-hours-card">
                <div class="status-section">
                    <div class="status-label">Estado Atual</div>
                    <div class="status-value" id="current-status">Estado</div>
                </div>
                <div class="hours-section">
                    <div class="hours-label">Horas Hoje</div>
                    <div class="hours-value" id="hours-today">0h 00m</div>
                </div>
            </div>

            <div class="action-buttons">
                <button class="punch-btn punch-btn-entry" id="entry-btn">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Registar Entrada</span>
                </button>
                <button class="punch-btn punch-btn-pause" id="pause-btn">
                    <i class="fas fa-pause"></i>
                    <span>Registar Pausa</span>
                </button>
                <button class="punch-btn punch-btn-exit" id="exit-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Registar Saída</span>
                </button>
            </div>
        </div>
    </div>
@endsection
