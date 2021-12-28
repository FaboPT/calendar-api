<?php

namespace App\Http\Controllers;

use App\Http\Requests\Availability\AvailabilityGetRequest;
use App\Http\Requests\Availability\StoreAvailabilityRequest;
use App\Http\Requests\Availability\UpdateAvailabilityRequest;
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
     * @param StoreAvailabilityRequest $request
     * @return JsonResponse
     */
    public function store(StoreAvailabilityRequest $request): JsonResponse
    {
        $request->merge(['user_id' => Auth::user()->getAuthIdentifier()]);
        return $this->availabilityService->store($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAvailabilityRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateAvailabilityRequest $request, int $id): JsonResponse
    {
        return $this->availabilityService->update($id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        return $this->availabilityService->destroy($id);
    }

    /**
     * Search availabilities
     * @param AvailabilityGetRequest $request
     * @return JsonResponse
     */

    public function index(AvailabilityGetRequest $request): JsonResponse
    {
        return $this->availabilityService->combined($request->users);
    }
}
