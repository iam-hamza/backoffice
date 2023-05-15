<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function success($data, $message = 'ok', $statusCode = 200)
    {
        return response()->json([
            'success'=>true,
            'message'=>$message,
            'data'=>$data
        ],$statusCode);
    }

    public function failed($message = 'Something went wrong!', $statusCode = 400)
    {
        return response()->json([
            'success'=>false,
            'message'=>$message,
            'data'=>[]
        ],$statusCode);
    }
}
