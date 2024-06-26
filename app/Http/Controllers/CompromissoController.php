<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompromissoRequest;
use App\Http\Requests\ConsultorRequest;
use App\Models\Compromisso;
use App\Models\Consultor;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
            //*Ininicar query e adicionar filtros
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

            //*Calcular toal horas
            $total_horas = $data->reduce(function ($carry, $item) {
                return $carry + Compromisso::findOrFail($item->id)->calcularTotalHoras();
            }, 0);

            $total_horas_completas = floor($total_horas / 60);
            $total_minutos_restantes = $total_horas % 60;
            $total_horas = sprintf('%02d:%02d', $total_horas_completas, $total_minutos_restantes);

            //*Calcular valor total
            $total_valor = $data->reduce(function ($carry, $item) {
                return $carry + Compromisso::findOrFail($item->id)->calcularValorTotal();
            }, 0);

            //*Montar e retornar instância do DataTables
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
                    //*RN01 - Na visualização dos compromissos, o sistema deve possibilitar visualizar um totalizador geral. Sendo este a soma dos totais de horas e soma dos totais de valor, dos filtros informados.
                    'total_horas' => $total_horas,
                    'total_valor' => 'R$ ' . number_format($total_valor, 2, ',', '.')
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

        return view('compromisso.show', ['compromisso' => $compromisso]);
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
     * @param CompromissoRequest $request
     * @param int $id_compromisso
     *
     * @return RedirectResponse
     */
    public function update(CompromissoRequest $request, int $id_compromisso): RedirectResponse
    {
        try {
            $compromisso = Compromisso::findOrFail($id_compromisso);
            $compromisso->updateOrFail($request->validated());

            return redirect()->route('compromissos.index')->with('success', 'Compromisso editado com sucesso');
        } catch (Exception $e) {
            return redirect()->route('compromissos.edit', ['compromisso' => $id_compromisso])->with('erro', $e->getMessage())->withInput();
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
