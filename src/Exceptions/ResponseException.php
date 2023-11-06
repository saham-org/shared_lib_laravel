<?php

namespace Saham\SharedLibs\Exceptions;

use Exception;

class ResponseException extends Exception
{
    public function render($request): mixed
    {
        return response()->error($this->getMessage(), $this->getCode());
    }
}
