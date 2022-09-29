<?php

namespace App\Http\Middleware;

use App\Models\UsersWithRole;
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
        $id = auth()->user()['id'];
        $role = UsersWithRole::where('user_id', $id)->with('role')->first();
        if(strtolower($role->role['name']) === 'training_center'){
            return $next($request);
        }
        return response()->json('Permission denied');
    }
}
