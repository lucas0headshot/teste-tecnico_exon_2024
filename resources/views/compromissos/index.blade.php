@extends('layouts.main')

@section('title', 'Exon Sistemas & Consultoria - Compromissos')

@section('content')
    <div>
        <ul>
            @foreach($compromissos as $compromisso)
                <li>{{ $compromisso->data }}</li>
            @endforeach
        </ul>
    </div>
@endsection
