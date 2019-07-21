<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
	/**
	 * List user paginate
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function index()
    {
    	$users = User::paginate();

    	return response()->json(['data' => $users]);
    }

    public function show($id)
    {
    	$user = User::findOrFail($id);
    	return response()->json(['data' => $user]);
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
	        'name' => 'required|max:50',
    		'username' => 'required|unique:users,username|max:50',
    		'password' => 'required|confirmed'
	    ]);

    	$user = DB::transaction(function () use ($request) {
	    	$user = new User();
	    	$user->fill($request->all());
	    	$user->password = Hash::make($request->password);
	    	$user->save();
    		return $user;
    	});

    	return response()->json(['data' => $user]);
    }

    public function update(Request $request, $id)
    {
    	$user = User::findOrFail($id);

    	$this->validate($request, [
	        'name' => 'required|max:50',
    		'username' => "required|max:50|unique:users,username,{$user->id}",
    		'password' => 'required|confirmed'
	    ]);

    	$user = DB::transaction(function () use ($request, $user) {
	    	$user->fill($request->all());
	    	$user->password = Hash::make($request->password);
	    	$user->save();
    		return $user;
    	});

    	return response()->json(['data' => $user]);
    }

    public function destroy($id)
    {
    	$user = User::findOrFail($id);
 		$user->delete();
    	return response()->json(['data' => $user]);
    }
}
