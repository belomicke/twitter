<?php

namespace App\Http\Controllers\Account\ProfileBanner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\ChangeProfileBannerRequest;
use App\Services\Account\AccountService;
use Illuminate\Http\JsonResponse;

class ChangeProfileBannerController extends Controller
{
    public function __construct(
        private readonly AccountService $accountService
    ) {}

    public function __invoke(ChangeProfileBannerRequest $request): JsonResponse
    {
        $banner = $request->file('profile_banner');

        if (is_array($banner) || is_null($banner)) {
            return response()->json([
                'success' => false
            ]);
        }

        $this->accountService->deletePreviousProfileBanner();
        $bannerPaths = $this->accountService->saveBannerPicture($banner);

        return response()->json([
            'success' => true,
            'data' => [
                'banners' => $bannerPaths
            ]
        ]);
    }
}
