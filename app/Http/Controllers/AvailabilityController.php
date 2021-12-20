<?php

namespace App\Http\Controllers;

use App\Http\Requests\AvailabilityRequest;
use App\Services\AvailabilityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AvailabilityController extends Controller
{
    private AvailabilityService $availabilityService;

    public function __construct(AvailabilityService $availabilityService)
    {
        $this->availabilityService = $availabilityService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AvailabilityRequest $request
     * @return JsonResponse
     */
    public function store(AvailabilityRequest $request): JsonResponse
    {
        $request->merge(['user_id' => Auth::user()->getAuthIdentifier()]);
        return $this->availabilityService->store($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AvailabilityRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(AvailabilityRequest $request, int $id): JsonResponse
    {
        return $this->availabilityService->update($id, $request->all());
    }
}
