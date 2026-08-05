@extends('layouts.app')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <span class="fw-bold"><i class="bi bi-clock-history me-1 text-primary"></i> Histórico de Empréstimos e Devoluções</span>

        {{-- Formulário de Pesquisa --}}
        <form action="{{ route('loans.history') }}" method="GET" class="d-flex gap-2">
            <input type="text"
                   name="search"
                   class="form-control form-control-sm"
                   placeholder="Buscar por nome..."
                   value="{{ request('search') }}">
            <button type="submit" class="btn btn-sm btn-primary">
                <i class="bi bi-search"></i>
            </button>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Chave</th>
                        <th>Retirado Por</th>
                        <th>Controlador Responsável</th>
                        <th>Data Retirada</th>
                        <th>Data Devolução</th>
                        <th class="text-center pe-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($history as $loan)
                        <tr>
                            <td class="ps-3 fw-bold">
                                <span class="badge bg-secondary">Nº {{ $loan->key->number ?? 'N/A' }}</span>
                                <small class="text-muted d-block">{{ $loan->key->description ?? '' }}</small>
                            </td>
                            <td class="fw-semibold">{{ $loan->borrower_name }}</td>
                            <td class="small text-muted">
                                <i class="bi bi-person me-1"></i>{{ $loan->controlador->nome ?? 'N/A' }}
                            </td>
                            <td class="small text-muted">
                                {{ $loan->borrowed_at ? $loan->borrowed_at->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td class="small text-muted">
                                {{ $loan->returned_at ? $loan->returned_at->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td class="text-center pe-3">
                                @if ($loan->returned_at)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">
                                        <i class="bi bi-check-circle me-1"></i>Devolvida
                                    </span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle">
                                        <i class="bi bi-hourglass-split me-1"></i>Empréstimo Ativo
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                Nenhum registro encontrado no histórico.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($history->hasPages())
        <div class="card-footer bg-white pt-3">
            {{ $history->links() }}
        </div>
    @endif
</div>
@endsection
