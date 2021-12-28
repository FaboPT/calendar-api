<?php

namespace App\Http\Middleware;

use App\Models\Availability;
use App\Traits\ResponseAPI;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanCreateAvailability
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

        if ($this->isCreatable($request)) {
            return $next($request);
        }
        return $this->error('Availability already created', Response::HTTP_CONFLICT);

    }

    private function isCreatable(Request $request): bool
    {
        return !Availability::MyAvailabilities()->where('start_date', $request->start_date)->where('end_date', $request->end_date)
            ->where('start_time', '<', $request->end_time)->where('end_time', '>', $request->start_time)->get()->count();

    }
}
