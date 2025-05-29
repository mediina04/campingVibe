<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }

    // GET /api/reservations
    public function index()
    {
        $reservations = Reservation::with(['accommodation', 'user'])->get();
        return response()->json($reservations, 200);
    }

    // GET /api/reservations/{id}
    public function show($id)
    {
        $reservation = Reservation::with(['accommodation', 'user'])->find($id);

        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        return response()->json($reservation);
    }

    // POST /api/reservations
    public function store(Request $request)
    {
        $validated = $request->validate([
            'accommodation_id' => 'required|exists:accommodations,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'guests' => 'required|integer|min:1',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        $reservation = Reservation::create($validated);

        return response()->json($reservation, 201);
    }

    // PUT /api/reservations/{id}
    public function update(Request $request, $id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        $this->authorize('update', $reservation); // Solo si usas Policies

        $validated = $request->validate([
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after:start_date',
            'guests' => 'sometimes|required|integer|min:1',
            'status' => 'sometimes|in:pending,confirmed,cancelled',
        ]);

        $reservation->update($validated);

        return response()->json($reservation);
    }

    // DELETE /api/reservations/{id}
    public function destroy($id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        $this->authorize('delete', $reservation); // Solo si usas Policies

        $reservation->delete();

        return response()->json(['message' => 'Reservation deleted successfully']);
    }
}
