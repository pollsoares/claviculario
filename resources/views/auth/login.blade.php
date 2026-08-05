@extends('layouts.app')

@section('content')
    <div class="row justify-content-center g-4">
        <div class="col-md-5">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white pt-3 pb-0 border-0">
                    {{-- Abas de Navegação (Entrar / Cadastrar) --}}
                    <ul class="nav nav-tabs card-header-tabs" id="authTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $errors->has('nome') ? '' : 'active' }} fw-semibold" id="login-tab"
                                data-bs-toggle="tab" data-bs-target="#login-pane" type="button" role="tab"
                                aria-controls="login-pane" aria-selected="{{ $errors->has('nome') ? 'false' : 'true' }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Entrar
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $errors->has('nome') ? 'active' : '' }} fw-semibold"
                                id="register-tab" data-bs-toggle="tab" data-bs-target="#register-pane" type="button"
                                role="tab" aria-controls="register-pane"
                                aria-selected="{{ $errors->has('nome') ? 'true' : 'false' }}">
                                <i class="bi bi-person-plus me-1"></i> Cadastrar-se
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body pt-4">

                    {{-- Alertas de sessão --}}
                    @if (session('success'))
                        <div class="alert alert-success py-2 small mb-3">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('info'))
                        <div class="alert alert-info py-2 small mb-3">
                            {{ session('info') }}
                        </div>
                    @endif

                    <div class="tab-content" id="authTabsContent">
                        {{-- PAINEL 1: LOGIN --}}
                        <div class="tab-pane fade {{ $errors->has('nome') ? '' : 'show active' }}" id="login-pane"
                            role="tabpanel" aria-labelledby="login-tab">
                            <form action="{{ route('login.submit') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="login_cpf" class="form-label fw-semibold">CPF do Controlador</label>
                                    <input type="text" name="cpf" id="login_cpf"
                                        class="form-control @error('cpf') is-invalid @enderror" placeholder="Digite seu CPF"
                                        value="{{ old('cpf') }}" required autofocus>
                                    @error('cpf')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="login_password" class="form-label fw-semibold">Senha</label>
                                    <input type="password" name="password" id="login_password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Digite sua senha" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" name="remember" class="form-check-input" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="remember">Lembrar-me</label>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 fw-semibold">
                                    <i class="bi bi-box-arrow-in-right me-1"></i> Entrar no Sistema
                                </button>
                            </form>
                        </div>

                        {{-- PAINEL 2: CADASTRO --}}
                        <div class="tab-pane fade {{ $errors->has('nome') ? 'show active' : '' }}" id="register-pane"
                            role="tabpanel" aria-labelledby="register-tab">
                            <form action="{{ route('register.store') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="reg_cpf" class="form-label fw-semibold">CPF</label>
                                    <input type="text" name="cpf" id="reg_cpf"
                                        class="form-control @error('cpf') is-invalid @enderror" placeholder="Digite seu CPF"
                                        value="{{ old('cpf') }}" required>
                                    @error('cpf')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="reg_nome" class="form-label fw-semibold">Nome Completo</label>
                                    <input type="text" name="nome" id="reg_nome"
                                        class="form-control @error('nome') is-invalid @enderror"
                                        placeholder="Digite seu nome completo" value="{{ old('nome') }}" required>
                                    @error('nome')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="reg_password" class="form-label fw-semibold">Senha</label>
                                    <input type="password" name="password" id="reg_password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Mínimo de 6 caracteres" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Campo Adicionado para resolver a validação --}}
                                <div class="mb-3">
                                    <label for="reg_password_confirmation" class="form-label fw-semibold">Confirmar
                                        Senha</label>
                                    <input type="password" name="password_confirmation" id="reg_password_confirmation"
                                        class="form-control" placeholder="Repita sua senha" required>
                                </div>

                                <button type="submit" class="btn btn-success w-100 fw-semibold">
                                    <i class="bi bi-person-plus me-1"></i> Cadastrar e Acessar
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
