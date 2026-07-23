@extends('layouts.app')

@section('content')
<div class="row g-4">
    <!-- Coluna Esquerda: Formulário de Retirada -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white font-weight-bold fw-bold py-3">
                <i class="bi bi-box-arrow-right me-1 text-primary"></i> Registrar Retirada
            </div>
            <div class="card-body">
                <form action="{{ route('loans.checkout') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="key_id" class="form-label font-weight-bold">Chave / Sala</label>
                        <select name="key_id" id="key_id" class="form-select" required>
                            <option value="">Selecione a chave...</option>
                            @foreach($availableKeys as $key)
                                <option value="{{ $key->id }}">Sala {{ $key->room_number }} ({{ $key->description ?? 'Sem desc.' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="user_id" class="form-label">Profissional</label>
                        <select name="user_id" id="user_id" class="form-select" required>
                            <option value="">Selecione o profissional...</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-semibold">
                        <i class="bi bi-check2-circle me-1"></i> Confirmar Retirada
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Coluna Direita: Chaves em Uso / Pendentes de Devolução -->
    <div class="col-md-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white fw-bold py-3 d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clock-history me-1 text-warning"></i> Chaves Emprestadas Agora</span>
                <span class="badge bg-warning text-dark">{{ $activeLoans->count() }} Em uso</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Sala</th>
                                <th>Profissional</th>
                                <th>Retirado às</th>
                                <th class="text-end">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activeLoans as $loan)
                                <tr>
                                    <td>
                                        <span class="badge bg-secondary fs-6">Sala {{ $loan->key->room_number }}</span>
                                    </td>
                                    <td>
                                        <strong class="d-block">{{ $loan->user->name }}</strong>
                                        <small class="text-muted">{{ $loan->user->email }}</small>
                                    </td>
                                    <td>{{ $loan->borrowed_at->format('H:i \h\s (d/m)') }}</td>
                                    <td class="text-end">
                                        <form action="{{ route('loans.checkin', $loan->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success fw-semibold">
                                                <i class="bi bi-box-arrow-in-left me-1"></i> Devolver
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        Todas as chaves estão na portaria no momento.
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
