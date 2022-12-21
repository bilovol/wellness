<?php
declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements RepositoryInterface
{
    /**
     * @var Builder|Model
     */
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    /**
     * @return Model|static
     */
    abstract public function getModel();

    /**
     * @return void
     */
    private function setModel()
    {
        $this->model = $this->getModel();
    }

    /**
     * @param array $columns
     * @return Collection|static[]
     */
    public function all(array $columns = ['*'])
    {
        return $this->model::all($columns);
    }

    /**
     * @param array $attributes
     * @return $this|Model
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * @param $id
     * @param array $attributes
     * @param array $options
     * @return int|bool
     */
    public function update($id, array $attributes = [], array $options = [])
    {
        return $this->get($id)->update($attributes, $options);
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id): int
    {
        return $this->model::destroy($id);
    }

    /**
     * @param $id
     * @param array $columns
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function get($id, array $columns = ['*'])
    {
        return $this->model->find($id, $columns);
    }
}
