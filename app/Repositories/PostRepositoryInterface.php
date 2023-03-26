<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Support\Collection;

interface PostRepositoryInterface
{
    public function find(int $id): Collection|Post;

    public function create(array $data): Post;

    public function update(int $id, array $data): Post;

    public function delete(int $id): void;

    public function all(): Collection;

    public function findByUser(int $userId): Collection|Post;

}
