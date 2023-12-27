<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AppBaseController extends Controller
{
    public function sendResponse($success, $result, $message, $errorMessage)
    {
        return Response::json([
            'success' => $success,
            'data' => $result,
            'message' => $message,
            'errorMessage' => $errorMessage,
        ]);
    }
}
