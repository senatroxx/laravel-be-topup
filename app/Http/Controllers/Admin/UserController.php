<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\CreateRequest;
use App\Http\Requests\Admin\User\UpdateRequest;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::latest()->paginate($request->get('limit', 10));

        return Response::status('success')
            ->message('List of users')
            ->result(new UserCollection($users));
    }

    public function show(User $user)
    {
        return Response::status('success')
            ->message('List of users')
            ->result(new UserResource($user));
    }

    public function store(CreateRequest $request)
    {
        $attributes = $request->validated();

        $user = User::create($attributes);

        return Response::status('success')
            ->message('User successfuly created')
            ->result(new UserResource($user));
    }

    public function update(User $user, UpdateRequest $request)
    {
        $attributes = $request->validated();

        $user->update($attributes);

        return Response::status('success')
            ->message('User successfuly updated')
            ->result(new UserResource($user));
    }

    public function destroy(User $user)
    {
        $user->delete();

        return Response::status('success')
            ->message('User successfuly deleted')
            ->result();
    }

    public function trashed(Request $request)
    {
        $users = User::onlyTrashed()->paginate($request->get('limit', 10));

        return Response::status('success')
            ->message('List of trashed users')
            ->result(new UserCollection($users));
    }

    public function restore(User $trashedUser)
    {
        $trashedUser->restore();

        return Response::status('success')
            ->message('User successfuly restored')
            ->result(new UserResource($trashedUser));
    }

    public function permanent(User $trashedUser)
    {
        $trashedUser->forceDelete();

        return Response::status('success')
            ->message('User successfuly permanently deleted')
            ->result();
    }
}
