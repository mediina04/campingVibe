<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function update(UpdateProfileRequest $request)
    {
        $profile = Auth::user();
        $profile->name = $request->name;
        $profile->surname1 = $request->surname1;
        $profile->email = $request->email;
        if ($request->filled('password')) {
            $profile->password = bcrypt($request->password);
        }
        if ($profile->save()) {
            return $this->successResponse($profile, 'User updated');
        }
        return response()->json(['status' => 403, 'success' => false]);
    }

    public function user(Request $request)
    {
        $user = $request->user()->load('roles');
        $avatar = '';
        if (count($user->media) > 0) {
            $avatar = $user->media[0]->original_url;
        }
        $user->avatar = $avatar;


        return $this->successResponse($user, 'User found');
    }

    public function reservations(Request $request)
    {
        $reservations = $request->user()->reservations()->with('accommodation.camping')->get();

        $data = $reservations->map(function($reservation) {
            return [
                'id' => $reservation->id,
                'camping' => $reservation->accommodation->camping->name ?? '',
                'start' => $reservation->check_in,
                'end' => $reservation->check_out,
                'people' => $reservation->guests,
                'web' => $reservation->accommodation->camping->website ?? '#'
            ];
        });

        return response()->json($data);
    }
    public function reviews(Request $request)
    {
        $reviews = $request->user()->reviews()->with('camping')->get();

        $data = $reviews->map(function($review) {
            return [
                'id' => $review->id,
                'camping' => $review->camping->name ?? '',
                'date' => $review->created_at->format('d/m/Y'),
                'rating' => $review->rating,
                'text' => $review->comment,
            ];
        });

        return response()->json($data);
    }
}
