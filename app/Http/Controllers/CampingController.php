<?php
namespace App\Http\Controllers;

use App\Models\Camping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
    public function index(Request $request)
    {
        $query = Camping::with('accommodations');

        // Búsqueda flexible por nombre, ciudad o provincia
        if ($request->filled('q')) {
            $q = mb_strtolower(trim($request->input('q')));
            $query->where(function($sub) use ($q) {
                $sub->whereRaw('LOWER(name) LIKE ?', ["%$q%"])
                    ->orWhereRaw('LOWER(location) LIKE ?', ["%$q%"]);
            });
        }

        // Validación sencilla de fechas
        if ($request->filled('arrival') && $request->filled('departure')) {
            $arrival = $request->input('arrival');
            $departure = $request->input('departure');
            $today = now()->toDateString();

            // Si alguna fecha es anterior a hoy o llegada es posterior/simultánea a salida, error
            if ($arrival < $today || $departure < $today || $arrival >= $departure) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Las fechas seleccionadas no son válidas.'
                ], 422);
            }
        }

        $campings = $query->get()->map(function ($camping) {
            $images = $camping->images;
            $camping->setAttribute('image', $images && count($images) > 0
                ? asset($images[0])
                : asset('images/default-camping.jpg'));
            // Asegura que lat/lng estén presentes en la respuesta
            $camping->setAttribute('latitude', $camping->latitude);
            $camping->setAttribute('longitude', $camping->longitude);
            return $camping;
        });

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
        // Carga los alojamientos relacionados
        $camping->load('accommodations');

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

    public function destacados()
    {
        $campings = Camping::with('accommodations')
            ->inRandomOrder()
            ->take(5)
            ->get()
            ->map(function ($camping) {
                $images = $camping->images;
                $camping->image = $images && count($images) > 0
                    ? asset($images[0])
                    : asset('images/default-camping.jpg');
                // Añade lat/lng a la respuesta
                $camping->latitude = $camping->latitude;
                $camping->longitude = $camping->longitude;
                return $camping;
            });

        return response()->json([
            'status' => 'success',
            'data' => $campings
        ]);
    }
}
