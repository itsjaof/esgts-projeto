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
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->position }}</td>
                        <td>EMP{{ $user->id }}</td>
                        <td><span class="status-badge status-active">{{ $user->status }}</span></td>
                        <td class="actions-cell">
                            <button class="action-btn" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn action-btn-danger" title="Eliminar" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $user->id }}').submit();">
                                <form action="{{ route('delete-empregado', ['id' => $user->id]) }}" method="POST" id="delete-form-{{ $user->id }}" onsubmit="return confirm('Tem a certeza que deseja eliminar este empregado?')">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <i class="fas fa-trash"></i>
                            </button>
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

            <form class="modal-form" id="add-employee-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="nome-completo">Nome Completo<span class="required">*</span></label>
                        <input type="text" id="nome-completo" name="nome-completo" placeholder="Nome Completo"
                            required>
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
                            <option value="gerente">Gerente</option>
                            <option value="supervisor">Supervisor</option>
                            <option value="operador">Operador</option>
                            <option value="auxiliar">Auxiliar</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id-interno">ID Interno</label>
                        <input type="text" id="id-interno" name="id-interno" placeholder="0001" value="0001">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="localizacao">Localização<span class="required">*</span></label>
                        <select id="localizacao" name="localizacao" required>
                            <option value="">Definir Localização</option>
                            <option value="escritorio-central">Escritório Central</option>
                            <option value="armazem-1">Armazém 1</option>
                            <option value="armazem-2">Armazém 2</option>
                            <option value="loja-1">Loja 1</option>
                            <option value="loja-2">Loja 2</option>
                        </select>
                    </div>
                </div>

                <div class="form-status">
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
                    <button type="button" class="btn-cancel" id="cancel-btn">Cancelar</button>
                    <button type="submit" class="btn-submit">Adicionar Empregado</button>
                </div>
            </form>
        </div>
    </div>
@endsection
