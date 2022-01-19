<?php

namespace App\Http\Middleware;

use App\Models\Event;
use App\Traits\ResponseAPI;
use App\Traits\Utils;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanCreateEvent
{
    use ResponseAPI, Utils;

    public function handle(Request $request, Closure $next)
    {
        if ($this->isCreatable($request)) {
            return $next($request);
        }
        return $this->error(
            'Not possible create a event, because there is already an event at that time, please change the event',
            Response::HTTP_CONFLICT
        );

    }

    private function isCreatable(Request $request): bool
    {
        return $this->isValidEvent($request)
            && $this->isValidDurationEvent($request);
    }

    private function isValidEvent(Request $request): bool
    {
        return !Event::MyOwnerEvents()->where('day_date', $request->day_date)
            ->where('start_time', '<', $this->parseTime($request->end_time))
            ->where('end_time', '>', $this->parseTime($request->start_time))->get()->count();
    }

    private function isValidDurationEvent(Request $request): bool
    {
        return $this->durationInMinutes($request) <= config('app.TIME_MAX');
    }

    private function durationInMinutes(Request $request): int
    {
        $start = Carbon::parse($request->start_time);
        $end = Carbon::parse($request->end_time);
        return $start->diffInMinutes($end);
    }
}
