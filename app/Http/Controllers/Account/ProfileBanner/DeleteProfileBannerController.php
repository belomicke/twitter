<?php

namespace App\Http\Controllers\Account\ProfileBanner;

use App\Http\Controllers\Controller;
use App\Services\Account\AccountService;
use App\Services\User\UserHelpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class DeleteProfileBannerController extends Controller
{
    public function __construct(
        private readonly AccountService $accountService
    ) {}

    public function __invoke(): JsonResponse
    {
        $viewer = Auth::user();

        $this->accountService->deletePreviousProfileBanner();
        $viewer->profile_banner_filename = '';
        $viewer->save();

        return response()->json([
            'success' => true,
            'data' => [
                'pictures' => UserHelpers::getProfileBannerPaths(
                    Auth::id(),
                    ''
                )
            ]
        ]);
    }
}
