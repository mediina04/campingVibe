<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['store', 'update', 'destroy']);
    }

    // GET /api/reviews
    public function index()
    {
        return response()->json(Review::with(['camping', 'user'])->get(), 200);
    }

    // GET /api/reviews/{id}
    public function show($id)
    {
        $review = Review::with(['camping', 'user'])->find($id);

        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        return response()->json($review);
    }

    // POST /api/reviews
    public function store(Request $request)
    {
        $data = $request->validate([
            'camping_id' => 'required|exists:campings,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $data['user_id'] = Auth::id();

        $review = Review::create($data);

        // Actualiza el rating medio del camping
        $camping = $review->camping;
        $camping->rating_avg = $camping->reviews()->avg('rating');
        $camping->save();

        return response()->json($review, 201);
    }

    // PUT /api/reviews/{id}
    public function update(Request $request, $id)
    {
        $review = Review::find($id);

        if (!$review || $review->user_id !== Auth::id()) {
            return response()->json(['message' => 'Review not found or unauthorized'], 403);
        }

        $data = $request->validate([
            'rating' => 'sometimes|required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $review->update($data);

        return response()->json($review);
    }

    // DELETE /api/reviews/{id}
    public function destroy($id)
    {
        $review = Review::find($id);

        if (!$review || $review->user_id !== Auth::id()) {
            return response()->json(['message' => 'Review not found or unauthorized'], 403);
        }

        $review->delete();

        return response()->json(['message' => 'Review deleted successfully']);
    }

    // GET /api/campings/{camping}/reviews
    public function reviewsByCamping($campingId)
    {
        $reviews = Review::where('camping_id', $campingId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($reviews);
    }
}
