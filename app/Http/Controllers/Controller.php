<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
	/**
	 * Default response data
	 * @param  mixed  $data
	 * @param  boolean $status
	 * @return \Illuminate\Http\JsonResponse
	 */
    protected function response($data, $status = true)
    {
    	return response()->json(compact('data', 'status'));
    }
}
