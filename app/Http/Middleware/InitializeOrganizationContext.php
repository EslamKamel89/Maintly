<?php

namespace App\Http\Middleware;

use App\Context\OrganizationContext;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InitializeOrganizationContext {
    public function handle(Request $request, Closure $next): Response {
        OrganizationContext::clear();
        if (
            auth()->check() &&
            auth()->user()->organization !== null
        ) {
            OrganizationContext::set(auth()->user()->organization);
        }
        return $next($request);
    }
}
