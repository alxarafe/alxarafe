<?php

namespace Alxarafe\Base\Testing;

use RuntimeException;

class HttpResponseException extends RuntimeException
{
    private $response;

    public function __construct($response, $message = "", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->response = $response;
    }

    public function getResponse()
    {
        return $this->response;
    }
}
