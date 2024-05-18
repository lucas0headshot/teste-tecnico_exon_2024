@extends('layouts.main')

@section('title', 'Compromissos')

@section('content')
    <h1>Compromissos</h1>

    <div class="mt-5">
        <a class="btn btn-success" href="{{ route('compromissos.create') }}">Cadastrar</a>

        @if(session('success'))
            <div class="alert alert-success mt-3" id="mensagemSucesso">
                {{ session('success') }}
            </div>

            <script type="module">
                setTimeout(() => {
                    $('#mensagemSucesso').remove();
                }, 3000);
            </script>
        @endif

        <table id="compromissos-list" class="table table-bordered">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Consultor</th>
                    <th>Horários</th>
                    <th>Total horas</th>
                    <th>Valor total</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                <tr>
                    <td>Total</td>
                    <td><!-- //TODO: somar tudo --></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <script type="module">
        $(document).ready(function() {
            const table = $('#compromissos-list').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('compromissos.index') }}",
                columns: [
                    {data: 'data', name: 'data'},
                    {data: 'consultor', name: 'consultor'},
                    {data: 'horarios', name: 'horarios'},
                    {data: 'intervalo', name: 'intervalo'},
                    {data: 'total_horas', name: 'total_horas'},
                    {data: 'valor_total', name: 'valor_total'},
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
