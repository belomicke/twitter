<?php

namespace App\Http\Controllers\User\Follows;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\User\FollowService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class FollowUserController extends Controller
{
    public function __construct(
        private readonly FollowService $followService,
    ) {}

    public function __invoke(User $user): JsonResponse
    {
        if (!Gate::allows('follow-user', $user)) {
            return response()->json([
                'success' => false
            ]);
        }

        $this->followService->follow(user: $user);

        return response()->json([
            'success' => true
        ]);
    }
}
