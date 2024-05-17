<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Repositories\User\IUserRepository;
use App\Traits\ResponseApi;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ResponseApi;

    /**
     * @param IUserRepository $userRepository
     */
    public function __construct(
        private readonly IUserRepository $userRepository
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->respondWithCollection(UserCollection::class,
            $this->userRepository->getAll());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        return $this->respondWithItem(UserResource::class,
            $this->userRepository->create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->respondWithItem(UserResource::class,
            $this->userRepository->findById($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
