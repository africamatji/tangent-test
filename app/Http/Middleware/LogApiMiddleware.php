<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Gateways\LogGateway;

class LogApiMiddleware
{
    public LogGateway $logGateway;

    public function __construct(LogGateway $logGateway)
    {
        $this->logGateway = $logGateway;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $logData = [
            'method' => $request->getMethod(),
            'url' => $request->fullUrl(),
            'status_code' => $response->getStatusCode(),
            'headers' => json_encode($response->headers->all()),
            'data' => json_encode($request->all()),
            'content' => $response->getContent()
        ];

        try {
            $this->logGateway->log($logData);
        }catch (\Exception $e) {
            Log::error('Error logging api req and res: ' . $e->getMessage());
        }

        return $response;
    }
}
