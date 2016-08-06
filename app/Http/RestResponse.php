<?php

namespace App\Http;

use Illuminate\Support\Facades\Response;

/*
 * This class is a extension of Response.
 * It sets HTTP status code by value determined as a key 'status_code' in array $response.
 */

class RestResponse extends Response
{
    public static function make(array $response, array $headers = array())
    {
        if (!empty($response['status_code'])){
            $status = $response['status_code'];
        }
        else {
            $status = 501;
        }
        return new \Illuminate\Http\Response($response, $status, $headers);
    }
}
