<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompromissoRequest;
use App\Http\Requests\ConsultorRequest;
use App\Models\Compromisso;
use App\Models\Consultor;
use Carbon\Carbon;
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
            $query = Compromisso::with('consultor')->latest();

            if ($request->filled('data_inicio')) {
                $query->whereDate('data', '>=', Carbon::parse($request->data_inicio)->toDateString());
            }
            if ($request->filled('data_fim')) {
                $query->whereDate('data', '<=', Carbon::parse($request->data_fim)->toDateString());
            }
            if ($request->filled('id_consultor')) {
                $query->where('id_consultor', $request->id_consultor);
            }

            $data = $query->get();

            $totalHoras = $data->reduce(function ($carry, $item) {
                return $carry + Compromisso::findOrFail($item->id)->calcularTotalHoras();
            }, 0);

            $totalValor = $data->reduce(function ($carry, $item) {
                return $carry + Compromisso::findOrFail($item->id)->calcularValorTotal();
            }, 0);

            return DataTables::of($data)
                ->addColumn('data', function ($row) {
                    return Carbon::parse($row->data)->format('d/m/Y');
                })
                ->addColumn('consultor', function ($row) {
                    return $row->consultor->nome;
                })
                ->addColumn('horarios', function ($row) {
                    return $row->hora_inicio . ' - ' . $row->hora_fim;
                })
                ->addColumn('intervalo', function ($row) {
                    return $row->intervalo;
                })
                ->addColumn('total_horas', function ($row) {
                    return gmdate('H:i', Compromisso::findOrFail($row->id)->calcularTotalHoras() * 60);
                })
                ->addColumn('valor_total', function ($row) {
                    return 'R$ ' . number_format(Compromisso::findOrFail($row->id)->calcularValorTotal(), 2, ',', '.');
                })
                ->addColumn('acao', function ($row) {
                    $rota_editar = route('compromissos.edit', $row->id);
                    $rota_excluir = route('compromissos.destroy', $row->id);
                    return '<a href="' . $rota_editar . '" class="edit btn btn-warning btn-sm">Editar</a>' .
                        '<form action="' . $rota_excluir . '" method="POST" style="display: inline;" class="ms-2">' .
                        csrf_field() .
                        method_field('DELETE') .
                        '<button type="submit" onClick="return confirm(\'Deseja realmente remover este compromisso?\')" class="delete btn btn-danger btn-sm">Remover</button>' .
                        '</form>';
                })
                ->rawColumns(['acao'])
                ->with([
                    'total_horas' => gmdate('H:i', $totalHoras * 60),
                    'total_valor' => 'R$ ' . number_format($totalValor, 2, ',', '.')
                ])
                ->make(true);
        }

        $consultores = Consultor::allOnlyIDAndName();
        return view('compromissos.index', compact('consultores'));
    }

    /**
     * Retorna a view p/ criar um Compromisso.
     *
     * @return View
     */
    public function create(): View
    {
        $consultores = Consultor::allOnlyIDAndName();

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
            return redirect()->route('compromissos.index')->with('success', 'Compromisso criado com sucesso');
        } catch (Exception $e) {
            return redirect()->route('compromissos.create')->withException($e)->withInput();
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
        $consultores = Consultor::all();

        return view('compromissos.show', ['compromisso' => $compromisso, 'consultores' => $consultores]);
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
        $consultores = Consultor::allOnlyIDAndName();

        return view('compromissos.create_edit', ['compromisso' => $compromisso, 'consultores' => $consultores]);
    }

    /**
     * Atualiza um compromisso.
     *
     * @param ConsultorRequest $request
     * @param int $id_compromisso
     *
     * @return RedirectResponse
     */
    public function update(ConsultorRequest $request, int $id_compromisso): RedirectResponse
    {
        try {
            Compromisso::findOrFail($id_compromisso)->updateOrFail($request->validated());
            return redirect()->route('compromissos.index')->with('success', 'Compromisso editado com sucesso');
        } catch (Exception $e) {
            return redirect()->route('compromissos.edit')->with('erro', $e->getMessage())->withInput();
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
        try {
            Compromisso::findOrFail($id_compromisso)->deleteOrFail();
            return redirect()->route('compromissos.index')->with('success', 'Compromisso removido com sucesso');
        } catch (Exception $e) {
            return redirect()->route('compromissos.index')->withException($e)->withInput();
        }
    }
}
