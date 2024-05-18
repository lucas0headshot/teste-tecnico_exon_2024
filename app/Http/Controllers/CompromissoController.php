<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompromissoRequest;
use App\Http\Requests\ConsultorRequest;
use App\Models\Compromisso;
use App\Models\Consultor;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class CompromissoController extends Controller
{
    /**
     * Retorna a view principal.
     *
     * @return View | JsonResponse
     */
    public function index(Request $request): View | JsonResponse
    {
        if ($request->ajax()) {
            $data = Consultor::latest()->get();
            return DataTables::of($data)
                ->addColumn('acao', function ($row) {
                    $rota_editar = route('compromissos.edit', $row->id);
                    $rota_excluir = route('compromissos.destroy', $row->id);
                    return '<a href="' . $rota_editar . '" class="edit btn btn-warning btn-sm">Editar</a>
                            <a href="' . $rota_excluir . '" class="delete btn btn-danger btn-sm">Remover</a>';
                })
                ->rawColumns(['acao'])
                ->make(true);
        }

        return view('compromissos.index');
    }

    /**
     * Retorna a view p/ criar um Compromisso.
     *
     * @return View
     */
    public function create(): View
    {
        $consultores = Consultor::all();

        return view('compromissos.create_edit', ['consultores' => $consultores]);
    }

    /**
     * Cria um Compromisso.
     *
     * @param CompromissoRequest $request
     *
     * @return RedirectResponse
     */
    public function store(CompromissoRequest $request): RedirectResponse
    {
        try {
            Compromisso::create($request->validated());
            return redirect('compromissos.index')->with('success', 'Compromisso criado com sucesso');
        } catch (Exception $e) {
            return redirect('compromissos.create')->withException($e)->withInput();
        }
    }

    /**
     * Retorna a view p/ visualizar um Compromisso.
     *
     * @param Compromisso $compromisso
     *
     * @return View
     */
    public function show(Compromisso $compromisso): View
    {
        $compromisso = Compromisso::findOrFail($compromisso);
        $consultores = Consultor::all();

        return view('compromissos.show', ['compromisso' => $compromisso, 'consultores' => $consultores]);
    }

    /**
     * Retorna a view p/ editar um Compromisso.
     *
     * @param Compromisso $compromisso
     *
     * @return View
     */
    public function edit(Compromisso $compromisso): View
    {
        $compromisso = Compromisso::findOrFail($compromisso);

        return view('compromissos.create_edit', ['compromisso' => $compromisso]);
    }

    /**
     * Atualiza um compromisso.
     *
     * @param ConsultorRequest $request
     * @param Compromisso $compromisso
     *
     * @return RedirectResponse
     */
    public function update(ConsultorRequest $request, Compromisso $compromisso): RedirectResponse
    {
        try {
            Compromisso::findOrFail($compromisso)->updateOrFail($request->validated());
            return redirect('compromissos.index')->with('success', 'Compromisso editado com sucesso');
        } catch (Exception $e) {
            return redirect('compromissos.create')->withException($e)->withInput();
        }
    }

    /**
     * Remove um Compromisso.
     *
     * @param Compromisso $Compromisso
     *
     * @return RedirectResponse
     */
    public function destroy(Compromisso $compromisso): RedirectResponse
    {
        try {
            Compromisso::findOrFail($compromisso)->deleteOrFail();
            return redirect('compromissos.index')->with('success', 'Compromisso removido com sucesso');
        } catch (Exception $e) {
            return redirect('compromissos.index')->withException($e)->withInput();
        }
    }
}
