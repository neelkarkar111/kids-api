<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireActiveChild
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $childId = $request->header('X-Child-Id');

        abort_unless($childId, 422, 'No child profile selected.');

        $child = auth()->user()->children()->find($childId);

        abort_unless($child, 403, 'Invalid child profile.');

        if ($child->last_active_date?->toDateString() !== now()->toDateString()) {
            $child->update([
                'last_active_date' => now(),
            ]);
        }

        $request->attributes->set('child', $child);

        return $next($request);
    }
}
