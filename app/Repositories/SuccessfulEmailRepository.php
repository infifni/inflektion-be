<?php

namespace App\Repositories;

use App\Models\SuccessfulEmail;

class SuccessfulEmailRepository extends EloquentBase implements SuccessfulEmailRepositoryInterface
{
    public function __construct(SuccessfulEmail $successfulEmail)
    {
        parent::__construct($successfulEmail);
    }
}
