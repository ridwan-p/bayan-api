<?php

namespace App\Http\Controllers;

use App\Reciter;
use Illuminate\Http\Request;

class ReciterController extends Controller
{
	/**
	 * List paginate reciters
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function index()
    {
    	$reciters = Reciter::paginate();

    	return response()->json['data' => $reciters];
    }

    /**
     * Show specific reciter
     * @param  integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
    	$reciter = Reciter::findOrFail($id);

    	return response()->json('data' => $reciter);
    }
}
