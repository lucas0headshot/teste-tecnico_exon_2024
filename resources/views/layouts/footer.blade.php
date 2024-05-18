<div class="container-fluid">
    <div class="row align-items-center justify-content-between">
        <div class="col-auto">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('consultores*') ? 'active' : '' }}" aria-current="page" href="{{ route('consultores.index') }}">Consultores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('compromissos*') ? 'active' : '' }}" aria-current="page" href="{{ route('compromissos.index') }}">Compromissos</a>
                </li>
            </ul>
        </div>
        <div class="col-auto">
            <h3>Exon Sistemas e Consultoria</h3>
        </div>
    </div>

    <hr>

    <div class="row text-center fw-bold">
        <p>Desenvolvido por Lucas &#169; {{ date('Y') }}</p>
    </div>
</div>
