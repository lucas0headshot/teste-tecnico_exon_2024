@extends('layouts.main')

@if(isset($constultor))
    @section('title', 'Editar Consultor')
@else
    @section('title', 'Criar Consultor')
@endif

@section('content')
    @if(isset($constultor))
        <form action="{{ route('consultores.update', $consultor->id) }}" id="formPutConsultor" method="PUT">
    @else
        <form action="{{ route('consultores.store') }}" id="formPostConsultor" method="POST">
    @endif

        @csrf
        <input type="text" name="nome" id="nome" value="{{ old('nome', isset($consultor) ? $consultor->nome : '') }}" placeholder="Digite o nome" maxlength="255" minlength="0" required>
        <input type="number" name="valor_hora" id="valor_hora" value="{{ old('valor_hora', isset($consultor) ? $consultor->valor_hora : 0) }}" placeholder="Digite o valor p/ hora" min="0" required>

        <button type="submit">{{ isset($consultor) ? 'Editar' : 'Criar'}}</button>
        <a href="{{ route('consultores.index') }}">Cancelar</a>
    </form>
@endsection
