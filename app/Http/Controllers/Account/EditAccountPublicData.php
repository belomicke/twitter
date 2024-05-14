<?php

namespace App\Http\Controllers\Account;

use App\Helpers\UserHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Account\EditAccountPublicDataRequest;
use App\Services\Account\AccountService;
use Illuminate\Http\JsonResponse;

class EditAccountPublicData extends Controller
{
    public function __construct(
        private readonly AccountService $accountService
    ) {}

    public function __invoke(EditAccountPublicDataRequest $request): JsonResponse
    {
        $name = $request->input('name');
        $bio = $request->input('bio');
        $location = $request->input('location');
        $link = $request->input('link');

        if ($link !== null && UserHelpers::checkLinkIsValid(link: $link)) {
            return response()->json([
                'message' => 'The link field must be a valid URL.'
            ], 422);
        }

        $user = $this->accountService->editProfileInfo(
            name: $name,
            bio: $bio,
            location: $location,
            link: $link
        );

        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user
            ]
        ]);
    }
}
