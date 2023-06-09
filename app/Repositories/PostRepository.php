<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

class PostRepository implements PostRepositoryInterface
{
    protected Post $model;
    public function __construct(Post $model)
    {
        $this->model = $model;
    }

    public function find(int $id): Collection|Post
    {
        return $this->model->with(['comments', 'category', 'user'])->find($id);
    }

    public function create(array $data): Post
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Post
    {
        $post = $this->model->findOrFail($id);
        $post->update($data);

        return $post;
    }

    public function delete(int $id): void
    {
        $post = $this->model->find($id);
        if($post) {
            $post->comments()->delete();
            $post->delete();
        }
    }

    public function all(): Collection
    {
        return $this->model->with(['comments', 'category', 'user'])->get();
    }

    public function findByUser(int $userId): Collection|Post
    {
        return $this->model->with(['comments', 'category', 'user'])->where('user_id', $userId)->get();
    }
}
