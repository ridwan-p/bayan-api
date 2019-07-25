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

    	return $this->response($reciters);
    }

    /**
     * Show specific reciter
     * @param  integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
    	$reciter = Reciter::findOrFail($id);

    	return $this->response($reciter);
    }

    /**
     * Store reciter in database
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "name" => 'required|max:25',
            'description' => 'required|max:255',
            'address' => 'required|max:255'
        ]);

        $reciter = DB::transaction(function () use ($request) {
            $reciter = new Reciter();
            $reciter->fill($request->all());
            $reciter->save();
            return $reciter;
        });

        return $this->response($reciter);
    }

    /**
     * Update reciter in database
     * @param  Request $request
     * @param  integer  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $reciter = Reciter::findOrFail($id);

        $this->validate($request, [
            "name" => 'required|max:25',
            'description' => 'required|max:255',
            'address' => 'required|max:255'
        ]);

        $reciter = DB::transaction(function () use ($request, $reciter) {
            $reciter->fill($request->all());
            $reciter->save();
            return $reciter;
        });

        return $this->response($reciter);
    }

    /**
     * Delete reciter in database
     * @param  integer  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $reciter = Reciter::findOrFail($id);
        $reciter->delete();
        return $this->response($reciter);
    }
}
