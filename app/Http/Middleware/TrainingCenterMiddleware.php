<?php

namespace App\Http\Middleware;

use App\Enums\UserRoles;
use App\Models\Users;
use Closure;
use http\Env\Response;
use Illuminate\Http\Request;

class TrainingCenterMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if( (int) auth()->user()['role'] === UserRoles::TRAINING_CENTER){
            return $next($request);
        }
        return response()->json('Permission denied');

    }
}
