<?php

namespace App\Repositories;

interface PostRepositoryInterface
{
    public function find(int $id);

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);

    public function all();

}
