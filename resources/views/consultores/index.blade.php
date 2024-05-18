@extends('layouts.main')

@section('title', 'Consultores')

@section('content')
    <h1>Consultores</h1>

    <div class="mt-5">
        <a class="btn btn-success" href="{{ route('consultores.create') }}">Cadastrar</a>

        <table id="consultores-list" class="table table-bordered">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Valor Hora</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <script type="module">
        $(document).ready(function() {
            const table = $('#consultores-list').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('consultores.index') }}",
                columns: [
                    {data: 'nome', name: 'nome'},
                    {data: 'valor_hora', name: 'valor_hora'},
                    {
                        data: 'acao',
                        orderable: false,
                        searchable: false
                    }
                ],

                responsive: true,
                //FIXME: colReorder: true,

                language: {
                    url: '/json/DataTables/pt-BR.json',
                },
            });
        });
    </script>
@endsection
