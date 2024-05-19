@extends('layouts.main')

@section('title', 'Compromissos')

@section('content')
    <h1>Compromissos</h1>

    <div class="mt-5">
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

        @if(session('erro'))
            <div class="alert alert-success mt-3" id="mensagemErro">
                {{ session('erro') }}
            </div>

            <script type="module">
                setTimeout(() => {
                    $('#mensagemErro').remove();
                }, 3000);
            </script>
        @endif

        <div class="card">
            <div class="card-header bg-body">
                <h3>Filtros</h3>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label for="data_inicio" class="form-label">Data de Início</label>
                    <input type="date" id="data_inicio" class="form-control" name="data_inicio">
                </div>
                <div class="form-group mt-2">
                    <label for="data_fim" class="form-label">Data de Fim</label>
                    <input type="date" id="data_fim" class="form-control" name="data_fim">
                </div>
                <div class="form-group mt-2">
                    <label for="id_consultor" class="form-label">Consultor</label>
                    <select name="id_consultor" class="form-select" id="id_consultor">
                        <option value="0" selected disabled>Selecione</option>
                        @foreach($consultores as $consultor)
                            <option value="{{ $consultor->id }}">{{ $consultor->nome }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="card-footer bg-body text-end border-0">
                <button type="button" class="btn btn-primary" id="btnFiltrar">Filtrar</button>
                <button type="button" class="btn btn-secondary" id="btnLimpar">Limpar Filtros</button>
            </div>
        </div>

        <section class="mt-4">
            <a class="btn btn-success" href="{{ route('compromissos.create') }}">Cadastrar</a>

            <table id="compromissos-list" class="display w-100 responsive nowrap table table-bordered">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Consultor</th>
                        <th>Horários</th>
                        <th>Intervalo</th>
                        <th>Total horas</th>
                        <th>Valor total</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <td>Total</td>
                        <td><!-- Total aqui --></td>
                    </tr>
                </tfoot>
            </table>
        </section>
    </div>

    <script type="module">
        $(document).ready(function() {
            const table = $('#compromissos-list').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('compromissos.index') }}",
                    data: function(data) {
                        data.data_inicio = $('#data_inicio').val();
                        data.data_fim = $('#data_fim').val();
                        data.id_consultor = $('#id_consultor').val();
                    }
                },
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
                colReorder: true,

                language: {
                    url: '/json/DataTables/pt-BR.json',
                },

                drawCallback: function(settings) {
                    const api = this.api();
                    const json = api.ajax.json();

                    $('#compromissos-list tfoot td:eq(0)').html('Total');
                    $('#compromissos-list tfoot td:eq(1)').html(`${json.total_horas} - ${json.total_valor}`);
                }
            });


            $('#btnFiltrar').on('click', function() {
                table.draw();
            });

            $('#btnLimpar').on('click', function() {
                $('#data_inicio').val('');
                $('#data_fim').val('');
                $('#id_consultor').val(0).trigger('change');
                table.draw();
            });
        });
    </script>
@endsection
