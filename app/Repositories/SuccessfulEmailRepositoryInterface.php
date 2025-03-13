<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface SuccessfulEmailRepositoryInterface
{
    public function get($columns = ['*']): Collection;

    public function find(int $id): ?Model;
}
