<?php

namespace App\Exceptions;

use App\Helpers\Helpers;
use App\Helpers\Response;
use Illuminate\Http\Request;
use Exception;
use Throwable;

class RequestException extends Exception
{
    protected $message;
    protected $detailed_error;
    protected $code;
    protected $isLogin;

    public function __construct($message = "",$detailed_error = null, $code = 400)
    {
        parent::__construct($message, $code);
        $this->message = $message;
        $this->detailed_error = $detailed_error;
        $this->code = $code;
    }

    public function render(Request $request)
    {
        return response()->json(Response::error(json_decode($this->message,true),$this->detailed_error,$this->code), $this->code);
    }
}
