<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\Api\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        /** @var User $authUser */
        $authUser = auth()->user();

        AnonymousResourceCollection::wrap('users');

        return UserResource::collection($this->userService->getAvailableUsersForChatting($authUser));
    }

    /**
     * Display the specified resource.
     */
    public function show(): UserResource
    {
        return UserResource::make(auth()->user());
    }
}
