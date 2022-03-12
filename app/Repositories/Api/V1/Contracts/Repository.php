<?php

namespace App\Repositories\Api\V1\Contracts;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use App\Exceptions\RepositoryException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;
use App\Repositories\Api\V1\Contracts\Criteria;
use App\Exceptions\CriteriaDoesNotExistsException;
use App\Repositories\Api\V1\Contracts\CriteriaInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class Repository
 *
 * @package Bosnadev\Repositories\Eloquent
 */
abstract class Repository implements RepositoryInterface, CriteriaInterface
{
    /**
     * @var
     */
    protected $model;

    protected $newModel;

    /**
     * @var Collection
     */
    protected $criteria;

    /**
     * @var bool
     */
    protected $skipCriteria = false;

    /**
     * Prevents from overwriting same criteria in chain usage
     *
     * @var bool
     */
    protected $preventCriteriaOverwriting = true;
    /**
     * @var App
     */
    private $app;

    /**
     * @param App $app
     * @param Collection $collection
     *
     * @throws RepositoryException|BindingResolutionException
     */
    public function __construct(App $app, Collection $collection)
    {
        $this->app = $app;
        $this->criteria = $collection;
        $this->resetScope();
        $this->makeModel();
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    abstract public function model(): string;

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @param array $columns
     *
     * @return mixed
     *
     * @throws CriteriaDoesNotExistsException
     */
    public function all(array $columns = ['*'])
    {
        $this->applyCriteria();
        return $this->model->get($columns);
    }

    /**
     * @param $id
     * @param array $columns
     *
     * @return mixed
     *
     * @throws CriteriaDoesNotExistsException
     */
    public function find($id, array $columns = ['*'])
    {
        $this->applyCriteria();
        return $this->model->find($id, $columns);
    }

    /**
     * @param int|null $perPage
     * @param int|null $page
     * @param array $columns
     *
     * @return LengthAwarePaginator
     *
     * @throws CriteriaDoesNotExistsException
     */
    public function paginate(?int $perPage = null, ?int $page = null, array $columns = ['*']): LengthAwarePaginator
    {
        $this->applyCriteria();
        return $this->model->paginate($perPage, $columns);
    }

    /**
     * @return mixed
     *
     * @throws CriteriaDoesNotExistsException
     */
    public function first()
    {
        $this->applyCriteria();
        return $this->model->first();
    }

    /**
     * @param array $columns
     *
     * @return mixed
     *
     * @throws CriteriaDoesNotExistsException
     */
    public function firstOrFail(array $columns = ['*'])
    {
        $this->applyCriteria();
        return $this->model->firstOrFail($columns);
    }

    /**
     * @return mixed
     *
     * @throws CriteriaDoesNotExistsException
     */
    public function count()
    {
        $this->applyCriteria();
        return $this->model->count();
    }

    /**
     * @param string $column
     *
     * @return int
     *
     * @throws CriteriaDoesNotExistsException
     */
    public function sum(string $column): int
    {
        $this->applyCriteria();
        return $this->model->sum($column);
    }

    /**
     * @param array $relations
     *
     * @return self
     */
    public function with(array $relations): self
    {
        $this->model = $this->model->with($relations);
        return $this;
    }

    /**
     * @param string $value
     * @param string|null $key
     *
     * @return array
     *
     * @throws CriteriaDoesNotExistsException
     */
    public function lists(string $value, ?string $key = null): array
    {
        $this->applyCriteria();
        $lists = $this->model->lists($value, $key);
        if (is_array($lists)) {
            return $lists;
        }
        return $lists->all();
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * save a model without massive assignment
     *
     * @param array $data
     *
     * @return bool
     */
    public function saveModel(array $data): bool
    {
        foreach ($data as $k => $v) {
            $this->model->$k = $v;
        }
        return $this->model->save();
    }

    /**
     * @inheritDoc
     */
    public function update(Model &$model, array $payload, bool $setUpdateFlag = true): Model
    {
        $model->fill($payload);
        if ($setUpdateFlag) {
            $this->setUserAction($model, 'updated_by');
        }
        $model->save();

        return $model;
    }

    public function delete(Model &$model, bool $setDeleteFlag = true): void
    {
        if ($setDeleteFlag) {
            $this->setDeletedFlag($model);
        }
        $model->delete();
    }

    /**
     * @param Model $model
     *
     * @throws Throwable
     */
    public function setDeletedFlag(Model &$model): void
    {
        $this->setUserAction($model, 'deleted_by');
        $model->saveOrFail();
    }

    /**
     * @param Model $model
     * @param string $attribute
     *
     * @throws BindingResolutionException
     */
    public function setUserAction(Model &$model, string $attribute = 'created_by'): void
    {
        $model->$attribute = $this->getAuthor();
    }

    /**
     * @return mixed
     */
    public function getAuthor(): ?string
    {
        return request()->get('auth_username');
    }

    /**
     * @param $id
     * @param array $columns
     *
     * @throws CriteriaDoesNotExistsException
     */
    public function findByAttribute($attribute, $value, array $columns = ['*'])
    {
        $this->applyCriteria();
        return $this->model->where($attribute, '=', $value)->first($columns);
    }

    /**
     * @inheritDoc
     */
    public function findOrCreate(array $attributeWithValue, array $attributes = []): Model
    {
        return $this->model->newQuery()->firstOrCreate($attributeWithValue, $attributes);
    }

    /**
     * @param mixed $attribute
     * @param mixed $value
     * @param array $columns
     *
     * @return mixed
     *
     * @throws CriteriaDoesNotExistsException
     */
    public function findAllBy($attribute, $value, array $columns = ['*'])
    {
        $this->applyCriteria();
        return $this->model->where($attribute, '=', $value)->get($columns);
    }

    public function changeStatus(Model &$model, string $status, string $attribute = 'status', bool $updateFlag = true): Model
    {
        $model->$attribute = $status;
        if ($updateFlag) {
            $this->setUserAction($model, 'updated_by');
        }
        $model->saveOrFail();

        return $model;
    }

    /**
     * Find a collection of models by the given query conditions.
     *
     * @param array $where
     * @param array $columns
     * @param bool $or
     *
     * @return \Illuminate\Database\Eloquent\Collection|null
     *
     * @throws CriteriaDoesNotExistsException
     */
    public function findWhere($where, array $columns = ['*'], bool $or = false): Collection
    {
        $this->applyCriteria();

        $model = $this->model;

        foreach ($where as $field => $value) {
            if ($value instanceof \Closure) {
                $model = ! $or
                    ? $model->where($value)
                    : $model->orWhere($value);
            } elseif (is_array($value)) {
                if (count($value) === 3) {
                    [$field, $operator, $search] = $value;
                    $model = ! $or
                        ? $model->where($field, $operator, $search)
                        : $model->orWhere($field, $operator, $search);
                } elseif (count($value) === 2) {
                    [$field, $search] = $value;
                    $model = ! $or
                        ? $model->where($field, '=', $search)
                        : $model->orWhere($field, '=', $search);
                }
            } else {
                $model = ! $or
                    ? $model->where($field, '=', $value)
                    : $model->orWhere($field, '=', $value);
            }
        }
        return $model->get($columns);
    }

    /**
     * @return Model
     *
     * @throws RepositoryException|BindingResolutionException
     */
    public function makeModel(): Model
    {
        return $this->setModel($this->model());
    }

    /**
     * Set Eloquent Model to instantiate
     *
     * @param $eloquentModel
     *
     * @return Model|mixed
     *
     * @throws RepositoryException|BindingResolutionException
     */
    public function setModel($eloquentModel)
    {
        $this->newModel = $this->app->make($eloquentModel);

        if (! $this->newModel instanceof Model) {
            throw new RepositoryException("Class {$this->newModel} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $this->newModel;
    }

    /**
     * @return $this
     */
    public function resetScope(): self
    {
        $this->skipCriteria(false);
        return $this;
    }

    /**
     * @param bool $status
     *
     * @return $this
     */
    public function skipCriteria(bool $status = true): self
    {
        $this->skipCriteria = $status;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getCriteria(): Collection
    {
        return $this->criteria;
    }

    /**
     * @param Criteria|array $criteria
     *
     * @return $this
     *
     * @throws CriteriaDoesNotExistsException
     */
    public function getByCriteria($criteria): self
    {
        if (! is_array($criteria)) {
            $criteria = Arr::wrap($criteria);
        }

        foreach ($criteria as $criterion) {
            if (is_string($criterion)) {
                $this->checkCriteriaIsValid($criterion);
                $criterion = new $criterion();
            }

            $this->pushCriteria($criterion);
        }

        return $this;
    }

    /**
     * @param Criteria|mixed $criteria
     *
     * @return $this
     */
    public function pushCriteria($criteria): self
    {
        if (! $criteria instanceof Criteria) {
            return $this;
        }

        if ($this->preventCriteriaOverwriting) {
            // Find existing criteria
            $key = $this->criteria->search(function ($item) use ($criteria) {
                return is_object($item) && (get_class($item) === get_class($criteria));
            });

            // Remove old criteria
            if (is_int($key)) {
                $this->criteria->offsetUnset($key);
            }
        }

        $this->criteria->push($criteria);
        return $this;
    }

    /**
     * @return $this
     *
     * @throws CriteriaDoesNotExistsException
     */
    public function applyCriteria(): self
    {
        if ($this->skipCriteria === true) {
            return $this;
        }

        foreach ($this->getCriteria() as $criteria) {
            if (is_string($criteria)) {
                $this->checkCriteriaIsValid($criteria);
                $criteria = new $criteria();
            }

            if ($criteria instanceof Criteria) {
                $this->model = $criteria->apply($this->model, $this);
            }
        }

        return $this;
    }

    /**
     * @return $this
     *
     * @throws BindingResolutionException
     * @throws RepositoryException
     */
    public function resetCriteria(): self
    {
        $this->criteria = new Collection();
        $this->makeModel();
        return $this;
    }

    /**
     * @return $this
     *
     * @throws CriteriaDoesNotExistsException
     */
    public function getQueryBuilder()
    {
        $this->applyCriteria();
        return $this->model;
    }

    /**
     * @param $criteria
     *
     * @return void
     *
     * @throws CriteriaDoesNotExistsException
     */
    private function checkCriteriaIsValid($criteria): void
    {
        if (! class_exists($criteria)) {
            throw new CriteriaDoesNotExistsException("criteria [${criteria}] does not exists.");
        }
    }
}
