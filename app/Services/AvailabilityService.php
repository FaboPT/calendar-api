<?php

namespace App\Services;

use App\Repositories\AvailabilityRepository;
use App\Traits\ResponseAPI;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
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
     * Service get all availabilities
     * @return JsonResponse
     */
    public function all(): JsonResponse
    {
      return $this->success(null, Response::HTTP_OK, $this->availabilityRepository->all(), 'availabilities');
    }

    /**
     * Service store new availability
     * @param array $data
     * @return JsonResponse
     */
    public function store(array $data): JsonResponse
    {
        try {
            DB::transaction(function () use (&$data) {
                $this->availabilityRepository->store($data);
            });

            return $this->success('Availability successfully created', Response::HTTP_CREATED);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), $e->getCode() ?: Response::HTTP_BAD_REQUEST);
        }

    }

    /** Service update availability
     * @param int $id
     * @param array $data
     * @return JsonResponse
     */
    public function update(int $id, array $data): JsonResponse
    {
        try {
            DB::transaction(function () use (&$id, &$data) {
                $this->availabilityRepository->update($id, $data);
            });

            return $this->success('Availability successfully updated');
        } catch (Exception $e) {
            return $this->error($e->getMessage(), $e->getCode() ?: Response::HTTP_BAD_REQUEST);
        }

    }

    /**
     * Service delete availability
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            DB::transaction(function () use (&$id) {
                $this->availabilityRepository->destroy($id);
            });

            return $this->success('Availability successfully deleted');

        } catch (Exception $e) {
            return $this->error($e->getMessage(), $e->getCode() ?: Response::HTTP_BAD_REQUEST);
        }

    }

    /**
     * Service get combined availabilities
     * @param array $attributes
     * @return JsonResponse
     */
    public function combined(array $attributes): JsonResponse
    {
        return $this->success(null, Response::HTTP_OK, $this->availabilityRepository->combined($attributes), 'availabilities');
    }
}
