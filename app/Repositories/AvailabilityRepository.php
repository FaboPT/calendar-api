<?php

namespace App\Repositories;

use App\Models\Availability;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Nette\NotImplementedException;
use Symfony\Component\HttpFoundation\Response;

class AvailabilityRepository extends BaseRepository
{
    protected Availability $availability;

    public function __construct(Availability $availability)
    {
        $this->availability = $availability;
        parent::__construct($this->availability);
    }

    public function all(): Collection
    {
        throw new NotImplementedException('Not implemented', Response::HTTP_NOT_IMPLEMENTED);
    }

    public function store(array $attributes): Model
    {
        return $this->availability->create($attributes);
    }

    public function update(int $id, array $attributes): Model
    {
        $availability = $this->availability->findOrFail($id);
        $availability->update($attributes);
        return $availability;

    }

    public function destroy(int $id): bool
    {
        $availability = $this->availability->findOrFail($id);
        return $availability->delete();
    }


}
