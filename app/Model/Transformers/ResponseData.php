<?php

namespace App\Model\Transformers;

use Symfony\Component\HttpFoundation\Response;


class ResponseData
{
    public static function make($result, $statusCode){

        $response = new \stdClass();
        $response->success = true;
        $response->data = $result ?: [];

        return new Response(json_encode($response), $statusCode, array('content-type' => 'application/json'));
    }

    public static function abort($result, $statusCode){

        $response = new \stdClass();
        $response->success = true;
        $response->errors = $result ?: [];

        return new Response(json_encode($response), $statusCode, array('content-type' => 'application/json'));
    }
}