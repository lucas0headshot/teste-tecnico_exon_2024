@extends('layouts.main')

@if(isset($compromisso))
    @section('title', 'Editar Compromisso')
@else
    @section('title', 'Criar Compromisso')
@endif

@section('content')
    @if(isset($compromisso))
        <form action="{{ route('compromissos.update', $compromisso->id) }}" id="formPutCompromisso" method="PUT">
    @else
        <form action="{{ route('compromissos.store') }}" id="formPostCompromisso" method="POST">
    @endif

        @csrf
        <select name="id_consultor" id="id_consultor">
            <!-- TODO: como pegar os consultores? -->
        </select>

        <input type="date" min="new Date()" value={{ old('data', isset($compromisso) ? $compromisso->data : '') }} required name="data" id="data">
        <input type="time" name="hora_inicio" value={{ old('hora_inicio', isset($compromisso) ? $compromisso->hora_inicio : '') }} id="hora_inicio" required>
        <input type="time" name="hora_fim" value={{ old('hora_fim', isset($compromisso) ? $compromisso->hora_fim : '') }} id="hora_fim" required>
        <input type="time" name="intervalo" value={{ old('intervalo', isset($compromisso) ? $compromisso->intervalo : '') }} id="intervalo" required>

        <button type="submit">{{ isset($compromisso) ? 'Editar' : 'Criar'}}</button>
        <a href="{{ route('compromissos.index') }}">Cancelar</a>
    </form>
@endsection
