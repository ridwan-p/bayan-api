<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
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


	    return [
	        "token" => [
	            "access_token" => $token,
	            "token_type"   => "Bearer",
	            "expire"       => (int) Auth::guard()->factory()->getTTL()
	        ]
	    ];
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
}
