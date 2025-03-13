<?php

namespace App\Exceptions;

use App\Utils\ErrorData;
use Exception;

class HttpResponseAsJsonException extends Exception
{
    protected int $status;

    protected array $errors;

    protected array $data;

    /**
     * HttpResponseAsJsonException constructor.
     *
     * @param ErrorData|array<ErrorData> $errorData
     */
    public function __construct(int $status, ErrorData|array $errorData)
    {
        parent::__construct(is_array($errorData) ? $errorData[0]->message : $errorData->message);

        $this->status = $status;
        $this->errors = is_array($errorData) ? $errorData : [$errorData];
    }

    /**
     * Get HTTP status.
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * Get errors.
     *
     * @return array<ErrorData>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
