<?php

namespace App\Http\Middleware;

use App\Models\Availability;
use App\Traits\ResponseAPI;
use App\Traits\Utils;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanCreateAvailability
{
    use ResponseAPI, Utils;

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
        return !Availability::MyAvailabilities()->where('start_date', $request->start_date)
            ->where('end_date', $request->end_date)
            ->where('start_time', '<', $this->parseTime($request->end_time))
            ->where('end_time', '>', $this->parseTime($request->start_time))->get()->count();

    }

    private function hasContent(Request $request): bool
    {
        return $request->getContent();
    }
}
