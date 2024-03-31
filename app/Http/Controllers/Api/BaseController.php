<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message, $code = "00", $statusCode = 200)
    {

        $response = [
            'status' => $code,
            'message' => $message,
            'data'    => $result,
        ];

        if ($result == []) unset($response['data']);

        return response()->json($response, $statusCode);
    }


    public function sendJsonResponse($response, $statusCode = 200)
    {
        return response()->json($response, $statusCode);
    }

    public function sendJsonErrorResponse($response, $statusCode = 400)
    {
        return response()->json($response, $statusCode);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = "01", $statusCode = 400)
    {
        $response = [
            'status' => $code,
            'message' => $error,
        ];


        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $statusCode);
    }
}
