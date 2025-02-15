<?php

namespace App\Http\Controllers;

use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class TranslationController extends Controller
{
    public function index(Request $request)
    {
        $translations = Translation::query()
            ->when($request->tag, fn($q) => $q->whereJsonContains('tags', $request->tag))
            ->when($request->key, fn($q) => $q->where('key', $request->key))
            ->when($request->id, fn($q) => $q->where('id', $request->id))
            ->when($request->content, fn($q) => $q->where('value', 'like', "%{$request->content}%"))
            ->paginate(50);

        return response()->json($translations);
    }

    public function store(Request $request)
    {
        $request->validate([
            'locale' => 'required|string',
            'key' => 'required|string|unique:translations,key',
            'value' => 'required|string',
            'tags' => 'nullable|array',
        ]);

        $translation = Translation::create($request->all());

        return response()->json($translation, 201);
    }

    public function update(Request $request, $id)
    {
        $transaction = Translation::find($id);
        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        $transaction->update($request->all());

        return response()->json([
            'message' => 'Transaction updated successfully',
            'transaction' => $transaction
        ], 200);
    }

    public function export()
    {
        $translations =  Translation::all(['locale', 'key', 'value'])->groupBy('locale');
        return response()->json($translations);
    }

    public function destroy($id)
    {
        $transaction = Translation::find($id);
        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }
        $transaction->delete();
        return response()->json([
            'message' => 'Transaction deleted successfully'
        ], 200);
    }
}
