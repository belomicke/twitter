<?php

namespace App\Http\Controllers\Account\ProfilePicture;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\ChangeProfilePictureRequest;
use App\Services\Account\AccountService;
use Illuminate\Http\JsonResponse;

class ChangeProfilePictureController extends Controller
{
    public function __construct(
        private readonly AccountService $accountService
    ) {}

    public function __invoke(ChangeProfilePictureRequest $request): JsonResponse
    {
        $picture = $request->file('profile_picture');

        if (is_array($picture) || is_null($picture)) {
            return response()->json([
                'success' => false
            ]);
        }

        $this->accountService->deletePreviousProfilePicture();
        $pictures = $this->accountService->saveProfilePicture($picture);

        return response()->json([
            'success' => true,
            'data' => [
                'pictures' => $pictures
            ]
        ]);
    }
}
