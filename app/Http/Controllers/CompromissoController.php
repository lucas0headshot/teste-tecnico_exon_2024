<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compromisso;
use App\Models\Consultor;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CompromissoController extends Controller
{
    /**
     * Retorna a view principal.
     *
     * @return View
     */
    public function index(): View
    {
        $compromissos = Compromisso::all();
        foreach($compromissos as $compromisso) {
            $total_horas = (strtotime($compromisso->hora_inicio) - strtotime($compromisso->hora_fim)) - strtotime($compromisso->intervalo);

            $consultor = Consultor::findOrFail($compromisso->id_consultor);
            $valor_total = $consultor->valor_hora * $total_horas;
            $nome_consultor = $consultor->nome;

            $compromisso->total_horas = $total_horas;
            $compromisso->valor_total = $valor_total;
            $compromisso->nome_consultor = $nome_consultor;
        }

        return view('compromissos.index', ['compromissos' => $compromissos]);
    }

    /**
     * Retorna a view p/ criar um Compromisso.
     *
     * @return View
     */
    public function create(): View
    {
        return view('compromissos.create_edit');
    }

    /**
     * Cria um Compromisso.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_consultor' => 'required|integer',
            'data' => 'required|date|after:now|date_format:d-m-Y',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fim' => 'required|after:hora_inicio|date_format:H:i',
            'intervalo' => 'required|date_format:H:i'
        ]);

        if ($validated) {
            $created = Compromisso::create($request->all());

            if ($created) {
                return to_route('compromissos.index');
            }
        }
    }

    /**
     * Retorna a view p/ visualizar um Compromisso.
     *
     * @param int $id_compromisso
     *
     * @return View
     */
    public function show(int $id_compromisso): View
    {
        $compromisso = Compromisso::findOrFail($id_compromisso);

        return view('compromissos.show', ['compromisso' => $compromisso]);
    }

    /**
     * Retorna a view p/ editar um Compromisso.
     *
     * @param int $id_compromisso
     *
     * @return View
     */
    public function edit(int $id_compromisso): View
    {
        $compromisso = Compromisso::findOrFail($id_compromisso);

        return view('compromissos.create_edit', ['compromisso' => $compromisso]);
    }

    /**
     * Atualiza um compromisso.
     *
     * @param Request $request
     * @param int $id_compromisso
     *
     * @return RedirectResponse
     */
    public function update(Request $request, int $id_compromisso): RedirectResponse
    {
        $validated = $request->validate([
            'id_consultor' => 'required|integer',
            'data' => 'required|date|after:now|date_format:d-m-Y',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fim' => 'required|after:hora_inicio|date_format:H:i',
            'intervalo' => 'required|date_format:H:i'
        ]);

        if ($validated) {
            $updated = Compromisso::findOrFail($id_compromisso)->updateOrFail($request->all());

            if ($updated) {
                return to_route('compromissos.index');
            }
        }
    }

    /**
     * Remove um Compromisso.
     *
     * @param int $id_compromisso
     *
     * @return RedirectResponse
     */
    public function destroy(int $id_compromisso): RedirectResponse
    {
        $deleted = Compromisso::findOrFail($id_compromisso)->deleteOrFail();

        if ($deleted) {
            return to_route('compromissos.index');
        }
    }
}
