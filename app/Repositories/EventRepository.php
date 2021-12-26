<?php

namespace App\Repositories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Nette\NotImplementedException;
use Symfony\Component\HttpFoundation\Response;

class EventRepository extends BaseRepository
{
    protected Event $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
        parent::__construct($this->event);
    }

    public function all(): Collection
    {
        throw new NotImplementedException('Not implemented', Response::HTTP_NOT_IMPLEMENTED);
    }

    public function store(array $attributes): Model
    {
        $event = $this->event->create($attributes);
        $users = $attributes['users'] ?? [];
        $event->eventUsers()->sync($users);
        return $event;
    }

    public function update(int $id, array $attributes): Model
    {
        $event = $this->event->findOrFail($id);
        $event->update($attributes);
        $users[] = $attributes['users'] ?? [];
        $event->eventUsers()->sync($users);
        return $event;

    }

    public function destroy(int $id): bool
    {
        $event = $this->event->findOrFail($id);
        return $event->eventUsers()->delete();
    }


}
