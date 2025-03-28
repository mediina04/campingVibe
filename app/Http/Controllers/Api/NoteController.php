<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index(): JsonResponse
    {
        $notes = Note::all();
        return response()->json($notes, 200);
    }

    public function store(Request $request): JsonResponse
    {
        $note = Note::create($request->all());
        return response()->json(['success' => true, 'data' => $note], 201);
    }

    public function show($id): JsonResponse
    {
        $note = Note::find($id);
        return response()->json($note, 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $note = Note::find($id);
        $note->update($request->all());
        return response()->json($note, 200);
    }

    public function destroy($id): JsonResponse
    {
        $note = Note::find($id);
        $note->delete();
        return response()->json(['success' => true], 200);
    }
}

