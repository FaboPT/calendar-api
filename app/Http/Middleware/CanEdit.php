<?php

namespace App\Http\Middleware;

use App\Models\Availability;
use App\Traits\ResponseAPI;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CanEdit
{
    use ResponseAPI;

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $availability = Availability::find($request->id);

        if ($this->isEditable($availability)) {
            return $next($request);
        }
        return $this->error('Access Denied', Response::HTTP_FORBIDDEN);

    }

    private function isEditable(Availability $availability): bool
    {
        return $availability->user_id === Auth::user()->getAuthIdentifier();
    }
}
