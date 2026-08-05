@extends('layouts.app')

@section('content')
    <div class="row g-4">
        <!-- Formulário de Cadastro -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white fw-bold py-3">
                    <i class="bi bi-plus-circle me-1 text-primary"></i> Cadastrar Nova Chave
                </div>
                <div class="card-body">
                    <form action="{{ route('keys.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="number" class="form-label fw-semibold">Número da Sala / Identificador</label>
                            <input type="text" name="number" id="number"
                                class="form-control @error('number') is-invalid @enderror"
                                placeholder="Ex: 101, 202-B, Auditório" value="{{ old('number') }}" required>
                            @error('number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">Descrição / Observações
                                (Opcional)</label>
                            <input type="text" name="description" id="description" class="form-control"
                                placeholder="Ex: Bloco A - 2º Andar" value="{{ old('description') }}">
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-semibold">
                            <i class="bi bi-save me-1"></i> Cadastrar Chave
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabela de Chaves Cadastradas -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white fw-bold py-3 d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-key me-1 text-primary"></i> Chaves Cadastradas</span>
                    <span class="badge bg-secondary">{{ $keys->count() }} Total</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Sala</th>
                                    <th>Descrição</th>
                                    <th>Status Atual</th>
                                    <th class="text-end">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($keys as $key)
                                    <tr>
                                        <td>
                                            <span class="fw-bold fs-6">Sala {{ $key->number }}</span>
                                        </td>
                                        <td class="text-muted">
                                            {{ $key->description ?? '—' }}
                                        </td>
                                        <td>
                                            @if ($key->is_available)
                                                <span
                                                    class="badge bg-success-subtle text-success border border-success-subtle">
                                                    <i class="bi bi-check-circle me-1"></i> Disponível
                                                </span>
                                            @else
                                                <span
                                                    class="badge bg-danger-subtle text-danger border border-danger-subtle">
                                                    <i class="bi bi-arrow-right-circle me-1"></i> Emprestada
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            @if ($key->is_available)
                                                <form action="{{ route('keys.destroy', $key->id) }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Tem certeza que deseja excluir esta chave?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        title="Excluir Chave">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <button class="btn btn-sm btn-outline-secondary" disabled
                                                    title="Não é possível excluir chaves emprestadas">
                                                    <i class="bi bi-lock"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            Nenhuma chave cadastrada ainda.
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
