<?php

namespace App\Repositories;

use App\Models\Log;

class LogRepository implements LogRepositoryInterface
{

    public function create(array $data): void
    {
        Log::create($data);
    }
}
