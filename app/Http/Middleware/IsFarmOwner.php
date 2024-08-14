<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsFarmOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $farm_id = $request->route('farm_id') ?? $request->farm_id;
        if ( ! $this->farmBelongsToUser($farm_id)) {
            return response('Unauthorized.', Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
    protected function farmBelongsToUser(int $farmId): bool
    {
        $farms = Auth::user()->farms;
        return $farms->contains($farmId);
    }
}
