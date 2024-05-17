<nav class="navbar navbar-expand-lg bg-body-tertiary d-flex justify-content-space-between">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="/img/logo.png" alt="Logo" width="30" height="24">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('consultores.index') }}">Consultores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('compromissos.index') }}">Compromissos</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
