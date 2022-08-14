<?php

namespace App\Repositories;

use App\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

abstract class Repository implements RepositoryInterface
{
    /**
     * @param  Model  $model
     * @param  array  $relations
     */
    public function __construct(
        protected Model $model,
        protected array $relations = []
    ) {
    }

    public function store($data)
    {
        $model = $this->model->newInstance($data);

        $model->save();

        return $model;
    }
}