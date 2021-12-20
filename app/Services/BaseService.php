<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;

abstract class BaseService
{
    /**
     * Service get all object
     * @return JsonResponse
     */
    abstract public function all(): JsonResponse;

    /**
     * Service store new object
     * @param array $data
     * @return JsonResponse
     */
    abstract public function store(array $data): JsonResponse;

    /** Service update object
     * @param int $id
     * @param array $data
     * @return JsonResponse
     */
    abstract public function update(int $id, array $data): JsonResponse;

    /** Service delete object
     * @param int $id
     * @return JsonResponse
     */
    abstract public function destroy(int $id): JsonResponse;
}
