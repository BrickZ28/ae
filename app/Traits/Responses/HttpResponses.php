<?php

namespace App\Traits\Responses;

trait HttpResponses
{
    protected function success($data, $msg = null, $code = 200)
    {
        return response()->json([
            'status' => 'Request successful',
            'message' => $msg,
            'data' => $data,
        ], $code);
    }

    protected function error($data, $msg, $code)
    {
        return response()->json([
            'status' => 'An error has occurred',
            'message' => $msg,
            'data' => $data,
        ], $code);
    }
}
