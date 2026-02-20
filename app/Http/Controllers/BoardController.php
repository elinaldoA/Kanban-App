<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function index(Request $request)
    {
        try {
            $boards = $request->user()->boards()->with('categories.tasks')->get();
            return response()->json($boards);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            $board = $request->user()->boards()->create([
                'title' => $request->title,
                'description' => $request->description,
            ]);

            return response()->json($board, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $board = Board::with('categories.tasks')
                ->where('user_id', $request->user()->id)
                ->findOrFail($id);

            return response()->json($board);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Board não encontrado'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $board = Board::where('user_id', $request->user()->id)->findOrFail($id);

            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            $board->update($request->all());
            return response()->json($board);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $board = Board::where('user_id', $request->user()->id)->findOrFail($id);
            $board->delete();
            return response()->json(['message' => 'Board excluído com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Board não encontrado'], 404);
        }
    }
}
