@extends('layouts.app')

@section('content')
    <div class="row g-4">
        {{-- Formulário de Empréstimo --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white fw-bold py-3">
                    <i class="bi bi-key me-1 text-primary"></i> Registrar Empréstimo de Chave
                </div>
                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success py-2 small mb-3">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('loans.checkout') }}" method="POST">
                        @csrf

                        {{-- Seleção da Chave (da tabela 'keys') --}}
                        <div class="mb-3">
                            <label for="key_id" class="form-label fw-semibold">Chave</label>
                            <select name="key_id" id="key_id" class="form-select @error('key_id') is-invalid @enderror"
                                {{ $keys->isEmpty() ? 'disabled' : '' }} required>
                                @if ($keys->isEmpty())
                                    <option value="" selected disabled>Nenhuma chave disponível cadastrada</option>
                                @else
                                    <option value="">-- Selecione uma chave disponível --</option>
                                    @foreach ($keys as $key)
                                        <option value="{{ $key->id }}"
                                            {{ old('key_id') == $key->id ? 'selected' : '' }}>
                                            Nº {{ $key->number }} - {{ $key->description }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('key_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Seleção do Usuário (da tabela 'users') --}}
                        <div class="mb-3">
                            <label for="user_id" class="form-label fw-semibold">Usuário (Quem retira)</label>
                            <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror"
                                required>
                                <option value="">-- Selecione o usuário --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Controlador do Acesso (Autenticado) --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted small mb-1">Controlador Responsável</label>
                            <input type="text" class="form-control bg-light"
                                value="{{ Auth::guard('controlador')->user()->nome ?? 'N/A' }}" disabled>
                        </div>

                        {{-- Alerta para direcionar o usuário a cadastrar chaves caso o banco esteja vazio --}}
                        @if ($keys->isEmpty())
                            <div class="alert alert-warning py-2 small mb-3">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                Nenhuma chave cadastrada ou disponível. <a href="{{ route('keys.index') }}"
                                    class="alert-link">Cadastrar nova chave</a>.
                            </div>
                        @endif

                        <button type="submit" class="btn btn-primary w-100 fw-semibold"
                            {{ $keys->isEmpty() ? 'disabled' : '' }}>
                            <i class="bi bi-box-arrow-right me-1"></i> Confirmar Retirada
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Tabela de Empréstimos Ativos --}}
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white fw-bold py-3">
                    <i class="bi bi-arrow-repeat me-1 text-primary"></i> Chaves Atualmente Emprestadas
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Chave</th>
                                    <th>Usuário</th>
                                    <th>Controlador</th>
                                    <th>Data/Hora</th>
                                    <th class="text-end pe-3">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($loans as $loan)
                                    <tr>
                                        <td class="ps-3 fw-bold">
                                            <span class="badge bg-primary me-1">Nº {{ $loan->key->number ?? 'N/A' }}</span>
                                            <small class="text-muted d-block">{{ $loan->key->description ?? '' }}</small>
                                        </td>
                                        <td class="fw-semibold">
                                            {{ $loan->user->name ?? ($loan->borrower_name ?? 'N/A') }}
                                        </td>
                                        <td class="small text-muted">
                                            <i class="bi bi-person me-1"></i>{{ $loan->controlador->nome ?? 'N/A' }}
                                        </td>
                                        <td class="small text-muted">
                                            {{ $loan->borrowed_at ? $loan->borrowed_at->format('d/m/Y H:i') : '' }}
                                        </td>
                                        <td class="text-end pe-3">
                                            <form action="{{ route('loans.checkin', $loan->id) }}" method="POST"
                                                class="d-inline">
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
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            Nenhuma chave emprestada no momento. Todas estão disponíveis!
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
