<?php

namespace App\Http\Controllers\Account\ProfilePicture;

use App\Http\Controllers\Controller;
use App\Services\Account\AccountService;
use Illuminate\Http\JsonResponse;

class DeleteProfilePictureController extends Controller
{
    public function __construct(
        private readonly AccountService $accountService
    ) {}

    public function __invoke(): JsonResponse
    {
        $pictures = $this->accountService->deleteProfilePicture();

        return response()->json([
            'success' => true,
            'data' => [
                'pictures' => $pictures
            ]
        ]);
    }
}
