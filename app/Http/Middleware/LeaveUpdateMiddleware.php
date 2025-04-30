<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\LeavesController;

class LeaveUpdateMiddleware
{
    public function handle($request, Closure $next)
    {
        $leaveController = new LeavesController();
        $leaveController->leaveSettings(); // Auto-update leave types

        return $next($request);
    }
}
