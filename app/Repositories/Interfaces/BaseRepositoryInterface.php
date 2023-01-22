<?php

namespace App\Repositories\Interfaces;

interface BaseRepositoryInterface
{
    public function all();
    public function find($id);

    public function paginate($limit = null);
    public function create(array $input);

    public function update(array $input, $id);

    public function delete($id);
}
