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
                <div class="calendar-placeholder">
                    <i class="fas fa-calendar fa-4x"></i>
                    <p>Calendário</p>
                </div>
            </div>

            <div class="picagens-list-section">
                <h2>
                    <i class="fas fa-clock"></i> Picagens
                </h2>
                <div class="picagens-list">
                    <div class="picagem-card">
                        <div class="picagem-info">
                            <div class="picagem-name">Nome</div>
                            <div class="picagem-times">
                                <span class="picagem-time">
                                    <i class="fas fa-sign-in-alt"></i> Hora Entrada
                                </span>
                                <span class="picagem-time">
                                    <i class="fas fa-sign-out-alt"></i> Hora Saída
                                </span>
                            </div>
                        </div>
                        <span class="picagem-status">Estado</span>
                    </div>
                    <div class="picagem-card">
                        <div class="picagem-info">
                            <div class="picagem-name">Nome</div>
                            <div class="picagem-times">
                                <span class="picagem-time">
                                    <i class="fas fa-sign-in-alt"></i> Hora Entrada
                                </span>
                                <span class="picagem-time">
                                    <i class="fas fa-sign-out-alt"></i> Hora Saída
                                </span>
                            </div>
                        </div>
                        <span class="picagem-status">Estado</span>
                    </div>
                    <div class="picagem-card">
                        <div class="picagem-info">
                            <div class="picagem-name">Nome</div>
                            <div class="picagem-times">
                                <span class="picagem-time">
                                    <i class="fas fa-sign-in-alt"></i> Hora Entrada
                                </span>
                                <span class="picagem-time">
                                    <i class="fas fa-sign-out-alt"></i> Hora Saída
                                </span>
                            </div>
                        </div>
                        <span class="picagem-status">Estado</span>
                    </div>
                    <div class="picagem-card">
                        <div class="picagem-info">
                            <div class="picagem-name">Nome</div>
                            <div class="picagem-times">
                                <span class="picagem-time">
                                    <i class="fas fa-sign-in-alt"></i> Hora Entrada
                                </span>
                                <span class="picagem-time">
                                    <i class="fas fa-sign-out-alt"></i> Hora Saída
                                </span>
                            </div>
                        </div>
                        <span class="picagem-status">Estado</span>
                    </div>
                    <div class="picagem-card">
                        <div class="picagem-info">
                            <div class="picagem-name">Nome</div>
                            <div class="picagem-times">
                                <span class="picagem-time">
                                    <i class="fas fa-sign-in-alt"></i> Hora Entrada
                                </span>
                                <span class="picagem-time">
                                    <i class="fas fa-sign-out-alt"></i> Hora Saída
                                </span>
                            </div>
                        </div>
                        <span class="picagem-status">Estado</span>
                    </div>
                    <div class="picagem-card">
                        <div class="picagem-info">
                            <div class="picagem-name">Nome</div>
                            <div class="picagem-times">
                                <span class="picagem-time">
                                    <i class="fas fa-sign-in-alt"></i> Hora Entrada
                                </span>
                                <span class="picagem-time">
                                    <i class="fas fa-sign-out-alt"></i> Hora Saída
                                </span>
                            </div>
                        </div>
                        <span class="picagem-status">Estado</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
