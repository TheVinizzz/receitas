<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Receita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReceitaController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/receitas",
     *     tags={"Receitas"},
     *     summary="Listar receitas do usuário",
     *     description="Retorna todas as receitas cadastradas pelo usuário autenticado",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de receitas",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nome", type="string", example="Bolo de Chocolate"),
     *                 @OA\Property(property="tempo_preparo_minutos", type="integer", example=45),
     *                 @OA\Property(property="porcoes", type="integer", example=8),
     *                 @OA\Property(property="ingredientes", type="string", example="2 xícaras de farinha..."),
     *                 @OA\Property(property="modo_preparo", type="string", example="Misture os ingredientes..."),
     *                 @OA\Property(property="id_categorias", type="integer", example=1),
     *                 @OA\Property(property="id_usuarios", type="integer", example=1)
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $receitas = Receita::with(['user', 'categoria'])
            ->where('id_usuarios', Auth::id())
            ->get();
        return response()->json($receitas);
    }

    /**
     * @OA\Post(
     *     path="/api/receitas",
     *     tags={"Receitas"},
     *     summary="Criar nova receita",
     *     description="Cria uma nova receita para o usuário autenticado",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nome","id_categorias","tempo_preparo_minutos","porcoes","ingredientes","modo_preparo"},
     *             @OA\Property(property="nome", type="string", example="Bolo de Chocolate"),
     *             @OA\Property(property="id_categorias", type="integer", example=1),
     *             @OA\Property(property="tempo_preparo_minutos", type="integer", example=45),
     *             @OA\Property(property="porcoes", type="integer", example=8),
     *             @OA\Property(property="ingredientes", type="string", example="2 xícaras de farinha..."),
     *             @OA\Property(property="modo_preparo", type="string", example="Misture os ingredientes...")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Receita criada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Dados inválidos"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_categorias' => 'required|exists:categorias,id',
            'nome' => 'required|string|max:255',
            'tempo_preparo_minutos' => 'required|integer|min:1',
            'porcoes' => 'required|integer|min:1',
            'modo_preparo' => 'required|string',
            'ingredientes' => 'required|string',
        ]);

        $receita = Receita::create([
            'id_usuarios' => Auth::id(),
            'id_categorias' => $request->id_categorias,
            'nome' => $request->nome,
            'tempo_preparo_minutos' => $request->tempo_preparo_minutos,
            'porcoes' => $request->porcoes,
            'modo_preparo' => $request->modo_preparo,
            'ingredientes' => $request->ingredientes,
        ]);

        return response()->json($receita->load(['user', 'categoria']), 201);
    }

    /**
     * @OA\Get(
     *     path="/api/receitas/{id}",
     *     tags={"Receitas"},
     *     summary="Obter detalhes de uma receita",
     *     description="Retorna os detalhes de uma receita específica do usuário",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da receita",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes da receita"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Receita não encontrada"
     *     )
     * )
     */
    public function show(string $id)
    {
        $receita = Receita::with(['user', 'categoria'])
            ->where('id_usuarios', Auth::id())
            ->findOrFail($id);
        return response()->json($receita);
    }

    /**
     * @OA\Put(
     *     path="/api/receitas/{id}",
     *     tags={"Receitas"},
     *     summary="Atualizar receita",
     *     description="Atualiza os dados de uma receita existente",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da receita",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nome", type="string", example="Bolo de Chocolate"),
     *             @OA\Property(property="id_categorias", type="integer", example=1),
     *             @OA\Property(property="tempo_preparo_minutos", type="integer", example=45),
     *             @OA\Property(property="porcoes", type="integer", example=8),
     *             @OA\Property(property="ingredientes", type="string"),
     *             @OA\Property(property="modo_preparo", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Receita atualizada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Receita não encontrada"
     *     )
     * )
     */
    public function update(Request $request, string $id)
    {
        $receita = Receita::where('id_usuarios', Auth::id())->findOrFail($id);

        $request->validate([
            'id_categorias' => 'sometimes|exists:categorias,id',
            'nome' => 'sometimes|string|max:255',
            'tempo_preparo_minutos' => 'sometimes|integer|min:1',
            'porcoes' => 'sometimes|integer|min:1',
            'modo_preparo' => 'sometimes|string',
            'ingredientes' => 'sometimes|string',
        ]);

        $receita->update($request->only([
            'id_categorias',
            'nome',
            'tempo_preparo_minutos',
            'porcoes',
            'modo_preparo',
            'ingredientes'
        ]));

        return response()->json($receita->load(['user', 'categoria']));
    }

    /**
     * @OA\Delete(
     *     path="/api/receitas/{id}",
     *     tags={"Receitas"},
     *     summary="Excluir receita",
     *     description="Remove uma receita do sistema",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da receita",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Receita excluída com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Receita não encontrada"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $receita = Receita::where('id_usuarios', Auth::id())->findOrFail($id);
        $receita->delete();
        return response()->json(['message' => 'Receita excluída com sucesso']);
    }

    /**
     * @OA\Get(
     *     path="/api/receitas/search/{term}",
     *     tags={"Receitas"},
     *     summary="Pesquisar receitas",
     *     description="Busca receitas por nome, ingredientes ou modo de preparo",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="term",
     *         in="path",
     *         description="Termo de busca",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Resultados da pesquisa"
     *     )
     * )
     */
    public function search(string $term)
    {
        $receitas = Receita::with(['user', 'categoria'])
            ->where('id_usuarios', Auth::id())
            ->where(function ($query) use ($term) {
                $query->where('nome', 'like', "%{$term}%")
                    ->orWhere('ingredientes', 'like', "%{$term}%")
                    ->orWhere('modo_preparo', 'like', "%{$term}%");
            })
            ->get();

        return response()->json($receitas);
    }

    /**
     * @OA\Get(
     *     path="/api/receitas/{id}/print",
     *     tags={"Receitas"},
     *     summary="Gerar versão para impressão",
     *     description="Retorna HTML formatado para impressão da receita",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da receita",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="HTML para impressão"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Receita não encontrada"
     *     )
     * )
     */
    public function print(string $id)
    {
        $receita = Receita::with(['user', 'categoria'])
            ->where('id_usuarios', Auth::id())
            ->findOrFail($id);

        $html = view('receita.print', compact('receita'))->render();
        
        return response()->json([
            'html' => $html,
            'receita' => $receita
        ]);
    }
}
