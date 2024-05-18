@extends('layouts.main')

@isset($consultor)
    @section('title', 'Editar Consultor')
@else
    @section('title', 'Criar Consultor')
@endisset

@section('content')
    <h1> {{ isset($consultor) ? 'Editar' : 'Criar'}} consultor</h1>

    <div class="card mt-5">
        <div class="card-body">
            @isset($consultor)
                <form id="consultorForm" action="{{ route('consultores.update', $consultor) }}" method="POST">
                @method('PUT')
            @else
                <form id="consultorForm" action="{{ route('consultores.store') }}" method="POST">
            @endisset
                    @csrf
                    <div class="form-group">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ old('nome', $consultor->nome ?? '') }}" placeholder="Digite o nome" maxlength="255" required>
                        @error('nome')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mt-2">
                        <label for="valor_hora" class="form-label">Valor Hora</label>
                        <input type="number" class="form-control @error('valor_hora') is-invalid @enderror" id="valor_hora" name="valor_hora" value="{{ old('valor_hora', $consultor->valor_hora ?? 'Digite o valor hora') }}" placeholder="Digite o valor por hora" min="0" required>
                        @error('valor_hora')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                <div class="card-footer text-end bg-body mt-2 border-0">
                    <button type="submit" class="btn btn-primary">{{ isset($consultor) ? 'Editar' : 'Criar' }}</button>
                    <a class="btn btn-secondary" href="{{ route('consultores.index') }}">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
