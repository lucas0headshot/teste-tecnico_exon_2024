@extends('layouts.main')

@section('title', 'Consultores')

@section('content')
    <h1>Consultores</h1>

    <div class="mt-5">
        <!-- Msgs de retorno -->
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

            @if(session('error'))
                <div class="alert alert-danger mt-3" id="mensagemErro">
                    {{ session('error') }}
                </div>

                <script type="module">
                    setTimeout(() => {
                        $('#mensagemErro').remove();
                    }, 3000);
                </script>
            @endif
        <!-- /Msgs de retorno -->

        <!-- Filtros -->
            <div class="card">
                <div class="card-header bg-body">
                    <h3>Filtros</h3>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" id="nome" class="form-control" placeholder="Digite um nome" name="nome">
                    </div>
                    <div class="form-group mt-2">
                        <label for="valor_hora" class="form-label">Valor da hora</label>
                        <input type="number" min="0" id="valor_hora" class="form-control" placeholder="Digite o valor da hora" name="valor_hora">
                    </div>
                </div>

                <div class="card-footer bg-body text-end border-0">
                    <button type="button" class="btn btn-primary" id="btnFiltrar">Filtrar</button>
                    <button type="button" class="btn btn-secondary" id="btnLimpar">Limpar Filtros</button>
                </div>
            </div>
        <!-- /Filtros -->

        <!-- Table -->
            <section class="mt-4">
                <a class="btn btn-success" href="{{ route('consultores.create') }}">Cadastrar</a>

                <table id="consultores-list" class="display w-100 responsive nowrap table table-bordered">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Valor Hora</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </section>
        <!-- /Table -->
    </div>

    <script type="module">
        $(document).ready(function() {
            //*Instanciar DataTable c/ processamento ServerSide e na rota /consultores
            const table = $('#consultores-list').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('consultores.index') }}",
                    data: function(data) {
                        data.nome = $('#nome').val();
                        data.valor_hora = $('#valor_hora').val();
                    }
                },
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
                colReorder: true,

                language: {
                    url: '/json/DataTables/pt-BR.json',
                },
            });

            //*Refazer table ao clicar em "Filtrar"
            $('#btnFiltrar').on('click', function() {
                table.draw();
            });

            //*Limpar filtros ao clicar em "Limpar filtros"
            $('#btnLimpar').on('click', function() {
                $('#nome').val('');
                $('#valor_hora').val('');
                table.draw();
            });
        });
    </script>
@endsection
