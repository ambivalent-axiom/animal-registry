<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAnimalOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $animal_id = $request->route('animal_id');
        if ( ! $this->animalBelongsToUser($animal_id)) {
            return response('Unauthorized.', Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
    protected function animalBelongsToUser(int $animalId): bool
    {
        $animals = Auth::user()->animals;
        return $animals->contains($animalId);
    }
}
