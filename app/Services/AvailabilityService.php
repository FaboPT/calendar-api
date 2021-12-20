<?php

namespace App\Services;

use App\Repositories\AvailabilityRepository;
use App\Traits\ResponseAPI;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Nette\NotImplementedException;
use Symfony\Component\HttpFoundation\Response;

class AvailabilityService extends BaseService
{
    use ResponseAPI;

    protected AvailabilityRepository $availabilityRepository;

    /**
     * Construct
     * @param AvailabilityRepository $availabilityRepository
     */
    public function __construct(AvailabilityRepository $availabilityRepository)
    {
        $this->availabilityRepository = $availabilityRepository;
    }

    /**
     * Service get all availability
     * @return JsonResponse
     * @throws NotImplementedException
     */
    public function all(): JsonResponse
    {
        throw new NotImplementedException('Not implemented', Response::HTTP_NOT_IMPLEMENTED);
    }

    /**
     * Service store new availability
     * @param array $data
     * @return JsonResponse
     */
    public function store(array $data): JsonResponse
    {
        DB::transaction(function () use (&$data) {
            $this->availabilityRepository->store($data);
        });
        return $this->success('Availability successfully created', Response::HTTP_CREATED);
    }

    /** Service update availability
     * @param int $id
     * @param array $data
     * @return JsonResponse
     */
    public function update(int $id, array $data): JsonResponse
    {
        DB::transaction(function () use (&$id, &$data) {
            $this->availabilityRepository->update($id, $data);
        });
        return $this->success('Availability successfully updated');
    }

    /**
     * Service delete availability
     * @param int $id
     * @return JsonResponse
     * @throws NotImplementedException
     */
    public function destroy(int $id): JsonResponse
    {
        throw new NotImplementedException('Not implemented', Response::HTTP_NOT_IMPLEMENTED);
    }
}
