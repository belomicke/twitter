<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Repository\Account\ViewerRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetViewerController extends Controller
{
    public function __construct(
        private readonly ViewerRepository $viewerRepository
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $user = $this->viewerRepository->getViewer();

        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user
            ]
        ]);
    }
}
