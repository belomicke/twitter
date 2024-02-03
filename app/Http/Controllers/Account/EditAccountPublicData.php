<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\EditAccountPublicDataRequest;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EditAccountPublicData extends Controller
{
    public function __construct(
        private readonly UserService $userService
    )
    {
    }

    public function __invoke(EditAccountPublicDataRequest $request): JsonResponse
    {
        $id = Auth::id();

        $name = $request->input('name');
        $bio = $request->input('bio');
        $location = $request->input('location');
        $link = $request->input('link');

        if ($link !== null && $this->checkLinkIsValid($link)) {
            return response()->json([
                'message' => 'The link field must be a valid URL.'
            ], 422);
        }

        $user = $this->userService->edit(
            id: $id,
            name: $name,
            bio: $bio,
            location: $location,
            link: $link
        );

        $user->save();

        return response()->json([
            'success' => true
        ]);
    }

    private function checkLinkIsValid(string $link): bool
    {
        $data = [
            'link' => $link
        ];

        $rules = [
            'link' => 'url'
        ];

        return Validator::make($data, $rules)->fails();
    }
}
