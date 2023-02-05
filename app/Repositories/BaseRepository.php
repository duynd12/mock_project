<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    protected $model;
    public function __construct(Model $_model)
    {
        $this->model = $_model;
    }


    /**
     * Retrieve all data of repository
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Retrieve all data of repository, paginated
     */
    public function paginate($limit = null)
    {
        $limit = is_null($limit) ? config('repository.pagination.limit', 10) : $limit;

        return $this->model->paginate($limit);
    }
    /**
     * Find data by id
     */
    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Save a new entity in repository
     */
    public function create($input)
    {
        // dd($input);
        return $this->model::create($input);
    }

    /**
     * Update a entity in repository by id
     */
    public function update(array $input, $id)
    {

        // $model = $this->model->findOrFail($id);
        // $model->fill($input);
        // $model->save();

        // return $this;

        return $this->model::findOrFail($id)->update($input);
    }

    /**
     * Delete a entity in repository by id
     *
     * @param $id
     *
     * @return int
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * Delete a entity in repository by id
     *
     * @param array
     */
    public function searchWithTime($array)
    {
        return $this->model->whereBetween('order_date', $array)->get();
    }
}
