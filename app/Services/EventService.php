<?php

namespace App\Services;

use App\Repositories\EventRepository;
use App\Traits\ResponseAPI;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Nette\NotImplementedException;
use Symfony\Component\HttpFoundation\Response;

class EventService extends BaseService
{
    use ResponseAPI;

    protected EventRepository $eventRepository;

    /**
     * Construct
     * @param EventRepository $eventRepository
     */
    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    /**
     * Service get all event
     * @return JsonResponse
     * @throws NotImplementedException
     */
    public function all(): JsonResponse
    {
        throw new NotImplementedException('Not implemented', Response::HTTP_NOT_IMPLEMENTED);
    }

    /**
     * Service store new event
     * @param array $data
     * @return JsonResponse
     */
    public function store(array $data): JsonResponse
    {
        try {
            DB::transaction(function () use (&$data) {
                $this->eventRepository->store($data);
            });

            return $this->success('Event successfully created', Response::HTTP_CREATED);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), $e->getCode() ?: Response::HTTP_BAD_REQUEST);
        }

    }

    /** Service update event
     * @param int $id
     * @param array $data
     * @return JsonResponse
     */
    public function update(int $id, array $data): JsonResponse
    {
        try {
            DB::transaction(function () use (&$id, &$data) {
                $this->eventRepository->update($id, $data);
            });

            return $this->success('Event successfully updated');

        } catch (Exception $e) {
            return $this->error($e->getMessage(), $e->getCode() ?: Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Service delete event
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {

            DB::transaction(function () use (&$id) {
                $this->eventRepository->destroy($id);
            });

            return $this->success('Event successfully deleted');
        } catch (Exception $e) {
            return $this->error($e->getMessage(), $e->getCode() ?: Response::HTTP_BAD_REQUEST);
        }
    }
}
