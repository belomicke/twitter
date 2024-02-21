<?php

namespace App\Http\Controllers\Follows;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowUserController extends Controller
{
    public function __invoke(Request $request, User $user): JsonResponse
    {
        $viewer = Auth::user();

        if ($viewer->id === $user->id) {
            return response()->json([
                'success' => false
            ]);
        }

        if ($viewer->follows->contains($user->id)) {
            return response()->json([
                'success' => false
            ]);
        }

        $viewer->follows()->attach($user->id);
        $viewer->follows_count += 1;
        $viewer->save();

        $user->followers_count += 1;
        $user->save();

        return response()->json([
            'success' => true
        ]);
    }
}
