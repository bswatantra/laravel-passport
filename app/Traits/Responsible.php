<?php

namespace App\Traits;


use Illuminate\Http\Response;

trait Responsible
{
    public function response($status = 'success', $message, $data = [], $code = Response::HTTP_OK)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}

