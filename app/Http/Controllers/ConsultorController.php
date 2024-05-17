<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consultor;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ConsultorController extends Controller
{
    /**
     * Retorna a view principal.
     *
     * @return View
     */
    public function index(): View
    {
        $consultores = Consultor::all();

        return view('consultores.index', compact('consultores'));
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
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'nome' => 'required|string|max:255|unique:consultores',
            'valor_hora' => 'required|min:0'
        ]);

        try {
            Consultor::create($request->all());
            return response()->json(['message' => 'Consultor criado com sucesso'], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage(), 500]);
        }
    }

    /**
     * Retorna a view p/ visualizar um Consultor.
     *
     * @param
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
     */
    public function edit(int $id_consultor): View
    {
        $consultor = Consultor::findOrFail($id_consultor);

        return view('consultores.create_edit', ['consultor' => $consultor]);
    }

    /**
     * Atualiza um Consultor.
     *
     * @param Request $request
     * @param int $id_consultor
     *
     * @return JsonResponse
     */
    public function update(Request $request, int $id_consultor): JsonResponse
    {
        $request->validate([
            'nome' => 'required|string|max:255|unique:consultores',
            'valor_hora' => 'required|min:0'
        ]);

        try {
            Consultor::findOrFail($id_consultor)->updateOrFail($request->all());
            return response()->json(['message' => 'Consultor editado com sucesso'], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove um Consultor.
     *
     * @param int $id_consultor
     *
     * @return JsonResponse
     */
    public function destroy(int $id_consultor): JsonResponse
    {
        try {
            //TODO: verificar vínculo compromisso
            Consultor::findOrFail($id_consultor)->deleteOrFail();

            return response()->json(['message' => 'Consultor removido com sucesso'], 204);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
