@extends('layouts.app')

@section('title','PointSystem - Empregados')

@section('content')

    <div class="main-content">
        <div class="content-header">
            <h1>Gestão de Colaboradores</h1>
            <p class="subtitle">Gerir as informações dos colaboradores.</p>
        </div>

        <div class="action-bar">
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Pesquisar Colaborador...">
                <button class="search-button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <button class="btn-primary" id="open-modal-btn">
                <i class="fas fa-plus"></i> Adicionar Colaborador
            </button>
        </div>

        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Cargo</th>
                        <th>ID Interno</th>
                        <th>Estado</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->position }}</td>
                            <td>EMP{{ $user->id }}</td>
                            @if($user->status == 'Ativo')
                                <td><span class="status-badge status-active">Ativo</span></td>
                            @else
                                <td><span class="status-badge status-inactive">Inativo</span></td>
                            @endif
                            <td class="actions-cell">
                                <button class="action-btn edit-user-btn" title="Editar"
                                    data-user-id="{{ $user->id }}"
                                    data-user-name="{{ $user->name }}"
                                    data-user-email="{{ $user->email }}"
                                    data-user-position="{{ $user->position }}"
                                    data-user-status="{{ $user->status }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('empregados.destroy', $user->id) }}" method="POST" class="inline-form">
                                    @csrf
                                    @method('DELETE')
                                    <button class="action-btn action-btn-danger" title="Eliminar" onclick="return confirm('Tem a certeza que deseja eliminar este utilizador?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Adicionar Empregado -->
    <div class="modal-overlay" id="modal-overlay">
        <div class="modal">
            <div class="modal-header">
                <h2>Adicionar Novo Empregado</h2>
                <button class="modal-close" id="close-modal-btn">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form class="modal-form" id="add-employee-form" method="POST">
                @csrf
                @method('POST')
                <div class="form-row">
                    <div class="form-group">
                        <label for="nome-completo">Nome Completo<span class="required">*</span></label>
                        <input type="text" id="nome-completo" name="nome-completo" placeholder="Nome Completo" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email<span class="required">*</span></label>
                        <input type="email" id="email" name="email" placeholder="Email" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="cargo">Cargo<span class="required">*</span></label>
                        <select id="cargo" name="cargo" required>
                            <option value="">Selecione o Cargo</option>
                            <option value="Gerente">Gerente</option>
                            <option value="Supervisor">Supervisor</option>
                            <option value="Operador">Operador</option>
                            <option value="Auxiliar">Auxiliar</option>
                        </select>
                    </div>

                    <div class="form-group">
                    <label for="type">Tipo de Utilizador<span class="required">*</span></label>
                        <select id="type" name="type" required>
                        <option value="employee">Empregado</option>
                            <option value="admin">Administrador</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Estado do Empregado</label>
                    <div class="toggle-container">
                        <input type="checkbox" id="status-toggle" class="toggle-input">
                        <label for="status-toggle" class="toggle-label">
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="status-text" id="status-text">Empregado inativo</span>
                    </div>
                </div>

                <div class="modal-actions">
                    <button type="submit" class="btn-submit">Adicionar Empregado</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Editar Empregado -->
    <div class="modal-overlay" id="edit-modal-overlay">
        <div class="modal">
            <div class="modal-header">
                <h2>Editar Empregado</h2>
                <button class="modal-close" id="close-edit-modal-btn">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form class="modal-form" id="edit-employee-form" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit-user-id" name="user_id">

                <div class="form-row">
                    <div class="form-group">
                        <label for="edit-nome-completo">Nome Completo<span class="required">*</span></label>
                        <input type="text" id="edit-nome-completo" name="nome-completo" placeholder="Nome Completo" required>
                    </div>

                    <div class="form-group">
                        <label for="edit-email">Email<span class="required">*</span></label>
                        <input type="email" id="edit-email" name="email" placeholder="Email" required>
                    </div>
                </div>

                <div class="form-row">
                <div class="form-group">
                        <label for="cargo">Cargo<span class="required">*</span></label>
                        <select id="cargo" name="cargo" required>
                            <option value="">Selecione o Cargo</option>
                            <option value="Gerente">Gerente</option>
                            <option value="Supervisor">Supervisor</option>
                            <option value="Operador">Operador</option>
                            <option value="Auxiliar">Auxiliar</option>
                        </select>
                    </div>

                    <div class="form-group">
                    <label for="type">Tipo de Utilizador<span class="required">*</span></label>
                        <select id="type" name="type" required>
                        <option value="employee">Empregado</option>
                            <option value="admin">Administrador</option>
                        </select>
                    </div>
                </div>

                <div class="form-status">
                    <label>Estado do Empregado</label>
                    <div class="toggle-container">
                        <input type="checkbox" id="edit-status-toggle" class="toggle-input">
                        <label for="edit-status-toggle" class="toggle-label">
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="status-text" id="edit-status-text">Empregado inativo</span>
                    </div>
                </div>

                <div class="modal-actions">
                    <button type="submit" class="btn-submit">Guardar Alterações</button>
                </div>
            </form>
        </div>
    </div>
@endsection
