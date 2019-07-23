<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
	/**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

	/**
	 * Auth User
	 * @param  Request $request
	 * @return array
	 */
    public function login(Request $request) {

	    // Validate
	    $this->validation($request);

	    // Attempt login
	    $credentials = $request->only("username", "password");

	    try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (JWTException $e) {
            return response()->json(['token_absent' => $e->getMessage()], $e->getStatusCode());
        }


	    return $this->respondWithToken($token);
	}

	/**
	 * Refresh Token
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function refresh()
	{
	    return $this->respondWithToken(Auth::guard()->refresh());
	}

    /**
     * Logout user
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Show user profile
     * @param  Request $request
     * @return array
     */
    public function profile(Request $request)
    {
        return $request->user();
    }

	/**
	 * Validation Role
	 * @param  Request $request
	 * @return array
	 */
	protected function validation(Request $request)
	{
		return $this->validate($request, [
    		'username' => 'required',
    		'password' => 'required'
	    ]);
	}

	/**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard()->factory()->getTTL() * 60
        ]);
    }
}
