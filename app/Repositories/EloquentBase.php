<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class EloquentBase implements BaseInterface
{
    private $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function model(): Model
    {
        return $this->model;
    }

    public function get($columns = ['*']): Collection
    {
        return $this->model()->get($columns);
    }

    public function find(int $id): ?Model
    {
        return $this->model()->find($id);
    }
}
