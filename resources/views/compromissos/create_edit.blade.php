@extends('layouts.main')

@isset($compromisso)
    @section('title', 'Editar Compromisso')
@else
    @section('title', 'Criar Compromisso')
@endisset

@section('content')
    <h1> {{ isset($compromisso) ? 'Editar' : 'Criar'}} compromisso</h1>

    <div class="card mt-5">
        <div class="card-body">
            @isset($compromisso)
                <form id="compromissoForm" action="{{ route('compromissos.update', $compromisso) }}" method="POST">
                @method('PUT')
            @else
                <form id="compromissoForm" action="{{ route('compromissos.store') }}" method="POST">
            @endisset
                    @csrf
                    <div class="form-group">
                        <label for="id_consultor" class="form-label">Consultor</label>
                        <select name="id_consultor" id="id_consultor" class="form-select" required>
                            <option value="0" {{ old('id_consultor') == 0 ? 'selected' : '' }} disabled>Selecione</option>
                            @foreach($consultores as $consultor)
                                <option value="{{ $consultor->id }}" {{ old('id_consultor') == $consultor->id ? 'selected' : '' }}>{{ $consultor->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mt-2">
                        <label for="data" class="form-label">Data</label>
                        <input type="date" class="form-control @error('data') is-invalid @enderror" id="data" name="data" value="{{ old('data', isset($compromisso) ? $compromisso->data : '') }}" min="{{ now()->format('Y-m-d') }}" required>
                        @error('data')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group mt-2">
                        <label for="hora_inicio" class="form-label">Hora de Início</label>
                        <input type="time" class="form-control @error('hora_inicio') is-invalid @enderror" id="hora_inicio" name="hora_inicio" value="{{ old('hora_inicio', isset($compromisso) ? $compromisso->hora_inicio : '') }}" required>
                        @error('hora_inicio')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group mt-2">
                        <label for="hora_fim" class="form-label">Hora de Fim</label>
                        <input type="time" class="form-control @error('hora_fim') is-invalid @enderror" id="hora_fim" name="hora_fim" value="{{ old('hora_fim', isset($compromisso) ? $compromisso->hora_fim : '') }}" required>
                        @error('hora_fim')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group mt-2">
                        <label for="intervalo" class="form-label">Intervalo</label>
                        <input type="time" class="form-control @error('intervalo') is-invalid @enderror" id="intervalo" name="intervalo" value="{{ old('intervalo', isset($compromisso) ? $compromisso->intervalo : '') }}" required>
                        @error('intervalo')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                <div class="card-footer text-end bg-body mt-2 border-0">
                    <button type="submit" class="btn btn-primary">{{ isset($compromisso) ? 'Editar' : 'Criar' }}</button>
                    <a class="btn btn-secondary" href="{{ route('compromissos.index') }}">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
