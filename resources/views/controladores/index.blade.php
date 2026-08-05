@extends('layouts.app')

@section('content')
<div class="row g-4">
    {{-- Formulário de Cadastro --}}
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-bold py-3">
                <i class="bi bi-person-plus me-1 text-primary"></i> Cadastrar Controlador de Acesso
            </div>
            <div class="card-body">

                @if (session('success'))
                    <div class="alert alert-success py-2 small mb-3">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('controladores.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="cpf" class="form-label fw-semibold">CPF do Controlador</label>
                        <input type="text"
                               name="cpf"
                               id="cpf"
                               class="form-control @error('cpf') is-invalid @enderror"
                               placeholder="Digite o CPF sem pontos ou traço"
                               value="{{ old('cpf') }}"
                               required>
                        @error('cpf')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nome" class="form-label fw-semibold">Nome Completo</label>
                        <input type="text"
                               name="nome"
                               id="nome"
                               class="form-control @error('nome') is-invalid @enderror"
                               placeholder="Digite o nome completo"
                               value="{{ old('nome') }}"
                               required>
                        @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Senha</label>
                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Digite a senha inicial"
                               required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-semibold">
                        <i class="bi bi-save me-1"></i> Cadastrar Controlador
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Tabela de Listagem --}}
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-bold py-3">
                <i class="bi bi-people me-1 text-primary"></i> Controladores Cadastrados
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Nome</th>
                                <th>CPF</th>
                                <th class="text-end pe-3">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($controladores as $controlador)
                                <tr>
                                    <td class="ps-3 fw-semibold">{{ $controlador->nome }}</td>
                                    <td>{{ preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "$1.$2.$3-$4", $controlador->cpf) }}</td>
                                    <td class="text-end pe-3">
                                        <form action="{{ route('controladores.destroy', $controlador->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja remover este controlador?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger border-0">
                                                <i class="bi bi-trash"></i> Excluir
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">
                                        Nenhum controlador de acesso cadastrado.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
