<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConsultorRequest;
use Illuminate\Http\Request;
use App\Models\Consultor;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class ConsultorController extends Controller
{
    /**
     * Retorna a view principal.
     *
     * @param Request $request
     *
     * @return View | JsonResponse
     */
    public function index(Request $request): View | JsonResponse
    {
        if ($request->ajax()) {
            $data = Consultor::latest()->get();
            return DataTables::of($data)
                ->addColumn('acao', function ($row) {
                    $rota_editar = route('consultores.edit', $row->id);
                    $rota_excluir = route('consultores.destroy', $row->id);
                    return '<a href="' . $rota_editar . '" class="edit btn btn-warning btn-sm">Editar</a>
                            <a href="' . $rota_excluir . '" class="delete btn btn-danger btn-sm">Remover</a>';
                })
                ->rawColumns(['acao'])
                ->make(true);
        }

        return view('consultores.index');
    }

    /**
     * Retorna a view p/ criar um Consultor
     *
     * @return View
     */
    public function create(): View
    {
        return view('consultores.create_edit');
    }

    /**
     * Cria um Consultor.
     *
     * @param ConsultorRequest $request
     *
     * @return RedirectResponse
     */
    public function store(ConsultorRequest $request): RedirectResponse
    {
        try {
            Consultor::create($request->validated());
            return redirect()->route('consultores.index')->with('success', 'Consultor criado com sucesso');
        } catch (Exception $e) {
            return redirect()->route('consultores.index')->withException($e)->withInput();
        }
    }

    /**
     * Retorna a view p/ visualizar um Consultor.
     *
     * @param
     *
     * @return View
     */
    public function show(Consultor $consultor): View
    {
        $consultor = Consultor::findOrFail($consultor);

        return view('consultores.index', ['consultor' => $consultor]);
    }

    /**
     * Retorna a view p/ editar um Consultor.
     *
     * @param Consultor $consultor
     *
     * @return View
     */
    public function edit(Consultor $consultor): View
    {
        $consultor = Consultor::findOrFail($consultor);

        return view('consultores.create_edit', ['consultor' => $consultor]);
    }

    /**
     * Atualiza um Consultor.
     *
     * @param ConsultorRequest $request
     * @param Consultor $consultor
     *
     * @return RedirectResponse
     */
    public function update(ConsultorRequest $request, Consultor $consultor): RedirectResponse
    {
        try {
            Consultor::findOrFail($consultor)->updateOrFail($request->validated());
            return redirect()->route('consultores.index')->with('success', 'Consultor criado com sucesso');
        } catch (Exception $e) {
            return redirect()->route('consultores.create')->withException($e)->withInput();
        }
    }

    /**
     * Remove um Consultor.
     *
     * @param Consultor $consultor
     *
     * @return RedirectResponse
     */
    public function destroy(Consultor $consultor): RedirectResponse
    {
        try {
            //TODO: verificar vínculo compromisso
            Consultor::findOrFail($consultor)->deleteOrFail();
            return redirect()->route('consultores.index')->with('success', 'Consultor removido com sucesso');
        } catch (Exception $e) {
            return redirect()->route('consultores.index')->withException($e)->withInput();
        }
    }
}
