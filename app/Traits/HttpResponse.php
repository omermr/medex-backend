<?php

namespace App\Traits;

trait HttpResponse
{
    protected static function success($data, $message = null, $code = 200)
    {
        return response()->json([
            'status'    => 'Request Was Successful',
            'message'   => $message,
            'data'      => $data
        ],  $code);
    }


    protected static function error($data, $message = null, $code)
    {
        return response()->json([
            'status'    => 'Error Has Occurred ...',
            'message'   => $message,
            'data'      => $data
        ],  intval($code));
    }
}
