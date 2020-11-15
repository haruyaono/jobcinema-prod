<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

abstract class AbstractRepository
{
    /** @var Model */
    protected $model;

    abstract public function getModelClass(): string;

    public function __construct()
    {
        $this->model = app($this->getModelClass());
    }

    public function getByIds(array $ids): Collection
    {
        return $this->model->whereIn($this->model->getKeyName(), $ids)->get();
    }

    public function getFirstWhere(...$params): Model
    {
        return $this->model->where(...$params)->first();
    }

    public function paginateArrayResults(array $data, int $perPage = 50)
    {
        $page = app('request')->input('page', 1);
        $offset = ($page * $perPage) - $perPage;

        return new LengthAwarePaginator(
            array_values(array_slice($data, $offset, $perPage, true)),
            count($data),
            $perPage,
            $page,
            [
                'path' => app('request')->url(),
                'query' => app('request')->query()
            ]
        );
    }
}
