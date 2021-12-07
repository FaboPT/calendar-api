<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws AuthenticationException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::firstWhere('email', $request->input('email'));

        $this->verifyUser($user, $request);

        return response()->json([
            'access_token' => $user->createToken($request->input('email'))->plainTextToken,
            'token_type' => 'Bearer',
            'success' => true,
        ], Response::HTTP_OK);

    }


    /**
     * @throws Exception
     */
    private function verifyUser($user, LoginRequest $request)
    {
        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            //throw new AuthenticationException(trans('auth.failed'));
            throw ValidationException::withMessages([
                'message' => trans('auth.failed'),
            ]);
        }
    }

}
