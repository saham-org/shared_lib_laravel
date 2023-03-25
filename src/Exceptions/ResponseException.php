<?php

namespace SahamLibs\Exceptions;

use Exception;
use Illuminate\Http\Response;

class ResponseException extends Exception
{
    public function render($request): mixed
    {
        return Response::create($this->getMessage(), $this->getCode())->throwResponse();
    }
}
