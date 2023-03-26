<?php

namespace App\Http\Gateways;

use App\Repositories\LogRepository;
use Illuminate\Support\Facades\Log;

class LogGateway
{

    public LogRepository $logRepository;

    public function __construct(LogRepository $logRepository)
    {
        $this->logRepository = $logRepository;
    }

    public function log(array $data): void
    {
        $this->logRepository->create($data);
    }
}
