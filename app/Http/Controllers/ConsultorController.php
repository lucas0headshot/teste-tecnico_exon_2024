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
            //*Iniciar query e adicionar filtros
            $query = Consultor::query();

            if ($request->filled('nome')) {
                $query->where('nome', 'LIKE', "%{$request->nome}%");
            }

            if ($request->filled("valor_hora")) {
                $query->where('valor_hora', '=', $request->valor_hora);
            }

            $data = $query->get();

            //*Montar e retornar instância do DataTables
            return DataTables::of($data)
                ->addColumn('valor_hora', function ($row) {
                    return 'R$ ' . number_format($row->valor_hora, 2, ',', '.');
                })
                ->addColumn('acao', function ($row) {
                    $rota_editar = route('consultores.edit', $row->id);
                    $rota_excluir = route('consultores.destroy', $row->id);
                    return '<a href="' . $rota_editar . '" class="edit btn btn-warning btn-sm">Editar</a>' .
                        '<form action="' . $rota_excluir . '" method="POST" style="display: inline;" class="ms-2">' .
                        csrf_field() .
                        method_field('DELETE') .
                        '<button type="submit" onClick="return confirm(\'Deseja realmente remover este consultor?\')" class="delete btn btn-danger btn-sm">Remover</button>' .
                        '</form>';
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
     * @param int $id_consultor
     *
     * @return View
     */
    public function show(int $id_consultor): View
    {
        $consultor = Consultor::findOrFail($id_consultor);
        return view('consultores.index', ['consultor' => $consultor]);
    }

    /**
     * Retorna a view p/ editar um Consultor.
     *
     * @param int $consultor
     *
     * @return View
     */
    public function edit(int $id_consultor): View
    {
        $consultor = Consultor::findOrFail($id_consultor);
        return view('consultores.create_edit', ['consultor' => $consultor]);
    }

    /**
     * Atualiza um Consultor.
     *
     * @param ConsultorRequest $request
     * @param int $id_consultor
     *
     * @return RedirectResponse
     */
    public function update(ConsultorRequest $request, int $id_consultor): RedirectResponse
    {
        try {
            $consultor = Consultor::findOrFail($id_consultor);
            $consultor->updateOrFail($request->validated());

            return redirect()->route('consultores.index')->with('success', 'Consultor editado com sucesso');
        } catch (Exception $e) {
            return redirect()->route('consultores.create')->withException($e)->withInput();
        }
    }

    /**
     * Remove um Consultor.
     *
     * @param int $id_consultor
     *
     * @return RedirectResponse
     */
    public function destroy(int $id_consultor): RedirectResponse
    {
        try {
            $consultor = Consultor::findOrFail($id_consultor);

            //*RN02 - Sistema deve permitir a exclusão de um consultor apenas se o mesmo não estiver vinculado a um compromisso.
            if ($consultor->hasCompromisso()) {
                return redirect()->route('consultores.index')->with('error', 'Consultor possui compromisso, não pode ser removido.');
            }

            $consultor->deleteOrFail();
            return redirect()->route('consultores.index')->with('success', 'Consultor removido com sucesso');
        } catch (Exception $e) {
            return redirect()->route('consultores.index')->withException($e);
        }
    }
}
