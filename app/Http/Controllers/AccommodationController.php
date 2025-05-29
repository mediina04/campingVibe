<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accommodation;

class AccommodationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store', 'update', 'destroy']);
        $this->middleware('admin')->only(['store', 'update', 'destroy']);
    }

    // Ver todas las accommodations
    public function index()
    {
        $accommodations = Accommodation::with('camping')->get();
        return response()->json($accommodations, 200);
    }

    // Ver una sola accommodation
    public function show($id)
    {
        $accommodation = Accommodation::with('camping')->find($id);

        if (!$accommodation) {
            return response()->json(['message' => 'Accommodation not found'], 404);
        }

        return response()->json($accommodation);
    }

    // Crear una accommodation (solo admin)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'camping_id' => 'required|exists:campings,id',
            'type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $accommodation = Accommodation::create($validated);

        return response()->json($accommodation, 201);
    }

    // Actualizar una accommodation (solo admin)
    public function update(Request $request, $id)
    {
        $accommodation = Accommodation::find($id);

        if (!$accommodation) {
            return response()->json(['message' => 'Accommodation not found'], 404);
        }

        $validated = $request->validate([
            'camping_id' => 'sometimes|required|exists:campings,id',
            'type' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $accommodation->update($validated);

        return response()->json($accommodation);
    }

    // Eliminar una accommodation (solo admin)
    public function destroy($id)
    {
        $accommodation = Accommodation::find($id);

        if (!$accommodation) {
            return response()->json(['message' => 'Accommodation not found'], 404);
        }

        $accommodation->delete();

        return response()->json(['message' => 'Accommodation deleted successfully']);
    }
}
