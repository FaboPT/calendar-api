<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws AuthenticationException
     * @throws ValidationException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $this->verifyUser($request);

        return response()->json([
            'access_token' => auth()->user()?->createToken($request->input('email'))->plainTextToken,
            'token_type' => 'Bearer',
            'success' => true,
        ], Response::HTTP_OK);

    }


    /**
     *
     * @throws AuthenticationException
     */
    private function verifyUser(LoginRequest $request)
    {
        if (!Auth::attempt($request->all())) {
            throw new AuthenticationException(trans('auth.failed'));
        }
    }

}
