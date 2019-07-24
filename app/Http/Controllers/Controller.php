<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected function response($data, $status = true)
    {
    	return response()->json(compact('data', 'status'))
    }
}
