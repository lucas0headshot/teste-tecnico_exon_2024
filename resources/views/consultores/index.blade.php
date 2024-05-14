@extends('layouts.main')

@section('title', 'Exon Sistemas & Consultoria - Consultores')

@section('content')
    <div>
        <ul>
            @foreach($consultores as $consultor)
                <li>{{ $consultor->nome }}</li>
            @endforeach
        </ul>
    </div>
@endsection
