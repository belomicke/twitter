<?php

namespace App\Http\Controllers\Account\ProfilePicture;

use App\Http\Controllers\Controller;
use App\Services\Account\AccountService;
use App\Services\User\UserHelpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class DeleteProfilePictureController extends Controller
{
    public function __construct(
        private readonly AccountService $accountService
    ) {}

    public function __invoke(): JsonResponse
    {
        $viewer = Auth::user();
        $filename = 'default-profile-picture.png';

        $this->accountService->deletePreviousProfilePicture();
        $viewer->profile_picture_filename = $filename;
        $viewer->save();

        return response()->json([
            'success' => true,
            'data' => [
                'pictures' => UserHelpers::getProfilePicturePaths(
                    Auth::id(),
                    $filename
                )
            ]
        ]);
    }
}
