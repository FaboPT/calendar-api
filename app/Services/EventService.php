<?php

namespace App\Services;

use App\Repositories\EventRepository;
use App\Traits\ResponseAPI;
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
        DB::transaction(function () use (&$data) {
            $this->eventRepository->store($data);
        });
        return $this->success('Event successfully created', Response::HTTP_CREATED);
    }

    /** Service update event
     * @param int $id
     * @param array $data
     * @return JsonResponse
     */
    public function update(int $id, array $data): JsonResponse
    {
        DB::transaction(function () use (&$id, &$data) {
            $this->eventRepository->update($id, $data);
        });
        return $this->success('Event successfully updated');
    }

    /**
     * Service delete event
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        DB::transaction(function () use (&$id) {
            $this->eventRepository->destroy($id);
        });
        return $this->success('Event successfully deleted');
    }
}
