@extends('layouts.main')

@section('title', 'Consultores')

@section('content')
    @include('consultores.create_edit')

    <div>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#consultorModal">
            Cadastrar
        </button>

        <table id="consultores-list" class="table table-bordered">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Valor Hora</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
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
                        name: 'acao',
                        orderable: true,
                        searchable: true
                    }
                ],

                responsive: true,
                colReorder: true,

                language: {
                    url: '/json/DataTables/pt-BR.json',
                },
            });
        });
    </script>
@endsection
