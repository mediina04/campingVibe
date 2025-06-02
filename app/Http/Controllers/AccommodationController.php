<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use Illuminate\Http\Request;

class AccommodationController extends Controller
{
    // GET /api/accommodations
    public function index()
    {
        return Accommodation::all();
    }

    // POST /api/accommodations
    public function store(Request $request)
    {
        $validated = $request->validate([
            'camping_id' => 'required|exists:campings,id',
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'description' => 'nullable|string',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
        ]);

        $accommodation = Accommodation::create($validated);

        return response()->json($accommodation, 201);
    }

    // GET /api/accommodations/{id}
    public function show($id)
    {
        $accommodation = Accommodation::findOrFail($id);
        return response()->json($accommodation);
    }

    // PUT /api/accommodations/{id}
    public function update(Request $request, $id)
    {
        $accommodation = Accommodation::findOrFail($id);

        $validated = $request->validate([
            'camping_id' => 'sometimes|exists:campings,id',
            'name' => 'sometimes|string|max:255',
            'type' => 'sometimes|string|max:100',
            'description' => 'nullable|string',
            'price_per_night' => 'sometimes|numeric|min:0',
            'capacity' => 'sometimes|integer|min:1',
        ]);

        $accommodation->update($validated);

        return response()->json($accommodation);
    }

    // DELETE /api/accommodations/{id}
    public function destroy($id)
    {
        $accommodation = Accommodation::findOrFail($id);
        $accommodation->delete();

        return response()->json(['message' => 'Accommodation deleted successfully.']);
    }
}
