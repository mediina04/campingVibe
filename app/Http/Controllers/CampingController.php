<?php

namespace App\Http\Controllers;

use App\Models\Camping;
use Illuminate\Http\Request;

class CampingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['store', 'update', 'destroy']);
        $this->middleware('admin')->only(['store', 'update', 'destroy']);
    }

    /**
     * Muestra todos los campings.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $campings = Camping::all();

        return response()->json([
            'status' => 'success',
            'data' => $campings
        ]);
    }

    /**
     * Muestra un camping específico.
     *
     * @param  \App\Models\Camping  $camping
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Camping $camping)
    {
        return response()->json([
            'status' => 'success',
            'data' => $camping
        ]);
    }

    /**
     * Crea un nuevo camping. Solo accesible por admins.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules());

        $camping = Camping::create($validated);

        return response()->json([
            'status' => 'success',
            'data' => $camping
        ], 201);
    }

    /**
     * Actualiza un camping existente. Solo accesible por admins.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Camping  $camping
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Camping $camping)
    {
        $validated = $request->validate($this->validationRules(true));

        $camping->update($validated);

        return response()->json([
            'status' => 'success',
            'data' => $camping
        ]);
    }

    /**
     * Elimina un camping. Solo accesible por admins.
     *
     * @param  \App\Models\Camping  $camping
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Camping $camping)
    {
        $camping->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Camping deleted successfully'
        ]);
    }

    /**
     * Reglas de validación para crear o actualizar un camping.
     *
     * @param  bool  $isUpdate
     * @return array
     */
    private function validationRules(bool $isUpdate = false): array
    {
        return [
            'name' => ($isUpdate ? 'sometimes|required' : 'required') . '|string|max:255',
            'location' => ($isUpdate ? 'sometimes|required' : 'required') . '|string|max:255',
            'description' => 'nullable|string',
        ];
    }
}
