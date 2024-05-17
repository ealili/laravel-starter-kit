<?php

namespace App\Http\Controllers;

use App\Exceptions\Auth\InvalidEmailOrPasswordException;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Traits\ResponseApi;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ResponseApi;

    /**
     * @throws InvalidEmailOrPasswordException
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            throw new InvalidEmailOrPasswordException();
        }

        /** @var User $user */
        $user = Auth::user();

        $access_token = $user->createToken('main')->plainTextToken;

        $user = new UserResource($user);

        return $this->respondWithCustomData([
            'user' => $user,
            'access_token' => $access_token
        ]);
    }
}
