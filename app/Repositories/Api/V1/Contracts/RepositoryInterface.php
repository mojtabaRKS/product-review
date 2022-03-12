<?php

namespace App\Repositories\Api\V1\Contracts;

use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    /**
     * @param array $columns
     *
     * @return mixed
     */
    public function all(array $columns = ['*']);

    /**
     * @param int|null $perPage
     * @param int|null $page
     * @param array $columns
     *
     * @return mixed
     */
    public function paginate(?int $perPage = null, ?int $page = null, array $columns = ['*']);

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param array $data
     *
     * @return bool
     */
    public function saveModel(array $data): bool;

    /**
     * @param Model $model
     * @param array $payload
     * @param bool $setUpdateFlag
     *
     * @throws Throwable
     */
    public function update(Model &$model, array $payload, bool $setUpdateFlag = true): Model;

    /**
     * @param Model $model
     * @param bool $setDeleteFlag
     *
     * @throws Throwable
     */
    public function delete(Model &$model, bool $setDeleteFlag = true): void;

    /**
     * @param $id
     * @param array $columns
     *
     * @return mixed
     */
    public function find($id, array $columns = ['*']);

    /**
     * @param $field
     * @param $value
     * @param array $columns
     *
     * @return mixed
     */
    public function findByAttribute($field, $value, array $columns = ['*']);

    /**
     * @param $field
     * @param $value
     * @param array $columns
     *
     * @return mixed
     */
    public function findAllBy($field, $value, array $columns = ['*']);

    /**
     * @param $where
     * @param array $columns
     *
     * @return mixed
     */
    public function findWhere($where, array $columns = ['*']);
}
