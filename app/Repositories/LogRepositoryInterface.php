<?php

namespace App\Repositories;

interface LogRepositoryInterface
{
    public function create(array $data): void;
}
