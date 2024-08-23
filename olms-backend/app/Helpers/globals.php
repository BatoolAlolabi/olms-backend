<?php

use Illuminate\Support\Facades\App;

if (!function_exists('array_null_filter')) {

    function array_null_filter($array)
    {
        return array_filter($array, function ($item) {
            return $item !== null;
        });
    }
}


if (!function_exists('success')) {

    function success($data = null): array
    {
        $response = ['isSuccessful' => true];
        $response['hasContent'] = $data ? true : false;
        $response['code'] = 200;
        $response['message'] = null;
        $response['detailed_error'] = null;
        $response['data'] = $data;
        return $response;
    }
}

if (!function_exists('error')) {

    function error($message = '', $errorCode = null, $detailedError = null, $debugeMessage = ''): array
    {
        $response = ['isSuccessful' => false];
        $response['code'] = $errorCode;
        $response['hasContent'] = false;
        $response['message'] = $message;
        $response['detailed_error'] = $detailedError;
        $response['data'] = null;

        if (App::isLocal()) {
            $response['debug_message'] = $debugeMessage;
        }
        return $response;
    }
}
