<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consultor;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ConsultorController extends Controller
{
    /**
     * Retorna a view principal.
     */
    public function index(): View
    {
        $consultores = Consultor::all();

        return view('consultores.index', ['consultores' => $consultores]);
    }

    /**
     * Retorna a view p/ criar um Consultor
     */
    public function create(): View
    {
        return view('consultores.create');
    }

    /**
     * Cria um Consultor.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'valor_hora' => 'required|min:0'
        ]);

        if ($validated) {
            $created = Consultor::create($request->all());

            if ($created) {
                return to_route('consultores.index');
            }
        }
    }

    /**
     * Retorna a view p/ visualizar um Consultor.
     */
    public function show(string $id_consultor): RedirectResponse
    {
        $consultor = Consultor::findOrFail($id_consultor);

        return to_route('consultores.index', ['consultor' => $consultor]);
    }

    /**
     * Retorna a view p/ editar um Consultor.
     */
    public function edit(int $id_consultor): View
    {
        $consultor = Consultor::findOrFail($id_consultor);

        return view('consultores.edit', ['consultor' => $consultor]);
    }

    /**
     * Atualiza um Consultor.
     */
    public function update(Request $request, int $id_consultor): RedirectResponse
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'valor_hora' => 'required|min:0'
        ]);

        if ($validated) {
            $updated = Consultor::findOrFail($id_consultor)->updateOrFail($request->all());

            if ($updated) {
                return to_route('consultores.index');
            }
        }
    }

    /**
     * Remove um Consultor.
     */
    public function destroy(int $id_consultor): RedirectResponse
    {
        $deleted = Consultor::findOrFail($id_consultor)->deleteOrFail();

        if ($deleted) {
            return to_route('consultores.index');
        }
    }
}
