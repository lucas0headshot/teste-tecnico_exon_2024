<div class="modal fade" id="consultorModal" tabindex="-1" aria-labelledby="consultorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md   ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="consultorModalLabel">{{ isset($consultor) ? 'Editar Consultor' : 'Criar Consultor' }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="consultorForm">
                    @csrf
                    @isset($consultor))
                        @method('PUT')
                    @endisset

                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome', $consultor->nome ?? '') }}" placeholder="Digite o nome" maxlength="255" required>
                    </div>
                    <div class="form-group">
                        <label for="valor_hora">Valor Hora</label>
                        <input type="number" class="form-control" id="valor_hora" name="valor_hora" value="{{ old('valor_hora', $consultor->valor_hora ?? 0) }}" placeholder="Digite o valor por hora" min="0" required>
                    </div>
            </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{ isset($consultor) ? 'Editar' : 'Criar' }}</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="module">
    $(document).ready(function() {
        $('#consultorModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const modal = $(this);
            const form = modal.find('form');
            const methodInput = form.find('#method');

            modal.find('.alert').remove();

            if (button.attr('id') === 'openCreateModal') {
                modal.find('.modal-title').text('Criar Consultor');
                form.attr('action', '{{ route('consultores.store') }}');
                methodInput.val('POST');
                modal.find('#nome').val('');
                modal.find('#valor_hora').val('');
                $('#saveButton').text('Criar');
            } else {
                const id = button.data('id');
                const nome = button.data('nome');
                const valorHora = button.data('valor_hora');

                modal.find('.modal-title').text('Editar Consultor');
                form.attr('action', '/consultores/' + id);
                methodInput.val('PUT');
                modal.find('#nome').val(nome);
                modal.find('#valor_hora').val(valorHora);
                $('#saveButton').text('Editar');
            }
        });

        $('#consultorForm').on('submit', function(event) {
            event.preventDefault();

            const form = $(this);
            const formData = form.serialize();
            const actionUrl = "{{ isset($consultor) ? route('consultores.update', $consultor->id) : route('consultores.store') }}";
            const method = form.find('input[name=_method]').val() || 'POST';

            $.ajax({
                url: actionUrl,
                method: method,
                data: formData,

                success: function(response) {
                    alert('Consultor salvo com sucesso');
                    location.reload();
                },

                error: function(response) {
                    const errors = response.responseJSON.errors;
                    let errorHtml = '<div class="alert alert-danger"><ul>';
                    $.each(errors, function(key, value) {
                        errorHtml += '<li>' + value[0] + '</li>';
                    });
                    errorHtml += '</ul></div>';
                    $('.modal-body').prepend(errorHtml);
                }
            });
        });
    });
</script>
