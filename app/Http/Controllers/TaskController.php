<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request, $categoryId)
    {
        try {
            $category = Category::findOrFail($categoryId);

            if ($category->board->user_id !== $request->user()->id) {
                return response()->json(['error' => 'Não autorizado'], 403);
            }

            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'due_date' => 'nullable|date',
            ]);

            $lastOrder = $category->tasks()->max('order') ?? 0;

            $task = $category->tasks()->create([
                'title' => $request->title,
                'description' => $request->description,
                'due_date' => $request->due_date,
                'order' => $lastOrder + 1,
            ]);

            return response()->json($task, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $task = Task::findOrFail($id);

            if ($task->category->board->user_id !== $request->user()->id) {
                return response()->json(['error' => 'Não autorizado'], 403);
            }

            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'due_date' => 'nullable|date',
            ]);

            $task->update($request->all());
            return response()->json($task);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $task = Task::findOrFail($id);

            if ($task->category->board->user_id !== $request->user()->id) {
                return response()->json(['error' => 'Não autorizado'], 403);
            }

            $task->delete();
            return response()->json(['message' => 'Tarefa excluída com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Tarefa não encontrada'], 404);
        }
    }

    public function move(Request $request, $id)
    {
        try {
            $task = Task::findOrFail($id);

            if ($task->category->board->user_id !== $request->user()->id) {
                return response()->json(['error' => 'Não autorizado'], 403);
            }

            $request->validate([
                'category_id' => 'required|exists:categories,id',
                'order' => 'required|integer',
            ]);

            $task->update([
                'category_id' => $request->category_id,
                'order' => $request->order,
            ]);

            return response()->json($task);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function reorder(Request $request, $categoryId)
    {
        try {
            $category = Category::findOrFail($categoryId);

            if ($category->board->user_id !== $request->user()->id) {
                return response()->json(['error' => 'Não autorizado'], 403);
            }

            $request->validate([
                'tasks' => 'required|array',
                'tasks.*.id' => 'required|exists:tasks,id',
                'tasks.*.order' => 'required|integer',
            ]);

            foreach ($request->tasks as $taskData) {
                Task::where('id', $taskData['id'])
                    ->where('category_id', $category->id)
                    ->update(['order' => $taskData['order']]);
            }

            return response()->json(['message' => 'Ordem atualizada com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
