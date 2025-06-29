<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\SearchRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    public function index(SearchRequest $request)
    {
        return UserResource::collection(
            User::search($request->only('search'))->paginate(10)
        );
    }
    
    public function store(StoreUserRequest $request)
    {
        $user = User::create(array_merge(
            $request->validated(),
            [
                'system_id' => $request->user()->system_id ? $request->user()->system_id : $request->system_id
            ]
        ));

        return new UserResource($user);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update(array_merge(
            $request->validated(),
            [
                'system_id' => $request->user()->system_id ? $request->user()->system_id : $request->system_id
            ]
        ));

        return new UserResource($user);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(null, 204);
    }
}
