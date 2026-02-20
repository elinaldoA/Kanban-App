<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Board;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request, $boardId)
    {
        try {
            $board = Board::where('user_id', $request->user()->id)->findOrFail($boardId);

            $request->validate([
                'title' => 'required|string|max:255',
                'color' => 'nullable|string',
            ]);

            $lastOrder = $board->categories()->max('order') ?? 0;

            $category = $board->categories()->create([
                'title' => $request->title,
                'color' => $request->color ?? '#007bff',
                'order' => $lastOrder + 1,
            ]);

            return response()->json($category, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);

            // Verificar se o board pertence ao usuário
            if ($category->board->user_id !== $request->user()->id) {
                return response()->json(['error' => 'Não autorizado'], 403);
            }

            $request->validate([
                'title' => 'required|string|max:255',
                'color' => 'nullable|string',
            ]);

            $category->update($request->all());
            return response()->json($category);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);

            if ($category->board->user_id !== $request->user()->id) {
                return response()->json(['error' => 'Não autorizado'], 403);
            }

            $category->delete();
            return response()->json(['message' => 'Categoria excluída com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Categoria não encontrada'], 404);
        }
    }

    public function reorder(Request $request, $boardId)
    {
        try {
            $board = Board::where('user_id', $request->user()->id)->findOrFail($boardId);

            $request->validate([
                'categories' => 'required|array',
                'categories.*.id' => 'required|exists:categories,id',
                'categories.*.order' => 'required|integer',
            ]);

            foreach ($request->categories as $categoryData) {
                Category::where('id', $categoryData['id'])
                    ->where('board_id', $board->id)
                    ->update(['order' => $categoryData['order']]);
            }

            return response()->json(['message' => 'Ordem atualizada com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
