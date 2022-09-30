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
        $user = UsersWithRole::where('user_id', auth()->user()['id'])->with('role')->first();
        if($user){
            if($user->role[0]['id'] === 3){
                return $next($request);
            }
            return response()->json('Permission denied');
        }
        return response()->json('Permission denied');
    }
}
