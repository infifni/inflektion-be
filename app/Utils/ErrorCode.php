<?php

namespace App\Utils;

enum ErrorCode: string
{
    case INTERNAL = 'internal';
    case RECORD_NOT_FOUND = 'recordNotFound';
    case UNAUTHORIZED = 'unauthorized';
}
