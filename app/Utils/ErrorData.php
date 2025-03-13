<?php

namespace App\Utils;

class ErrorData
{
    public ErrorCode $errorCode;

    public string $message;

    public array $data = [];

    public function __construct(ErrorCode $errorCode, string $message, array $data = [])
    {
        $this->errorCode = $errorCode;
        $this->message = $message;
        $this->data = $data;
    }
}
