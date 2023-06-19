<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UsersResource;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return UsersResource::collection(User::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * @param UserCreateRequest $request
     * @return UsersResource
     */
    public function store(UserCreateRequest $request): UsersResource
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);

        return new UsersResource($user);
    }

    /**
     * @param User $user
     * @return UsersResource
     */
    public function show(User $user): UsersResource
    {
        return new UsersResource($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * @param UserRequest $request
     * @param User $user
     * @return UsersResource
     */
    public function update(UserRequest $request, User $user): UsersResource
    {
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email')
        ]);

        return new UsersResource($user);
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response(null, 204);
    }
}

