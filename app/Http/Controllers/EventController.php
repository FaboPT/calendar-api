<?php

namespace App\Http\Controllers;

use App\Http\Requests\Event\StoreEventRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Services\EventService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    private EventService $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreEventRequest $request
     * @return JsonResponse
     */
    public function store(StoreEventRequest $request): JsonResponse
    {
        $request->merge(['user_id' => Auth::user()->getAuthIdentifier(), 'duration' => $this->duration($request)]);
        return $this->eventService->store($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateEventRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateEventRequest $request, int $id): JsonResponse
    {
        return $this->eventService->update($id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        return $this->eventService->destroy($id);
    }

    private function duration(StoreEventRequest $request): int
    {
        $start = Carbon::parse($request->start_time);
        $end = Carbon::parse($request->end_time);
        return $start->diffInMinutes($end);

    }
}
