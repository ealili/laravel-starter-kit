<?php

namespace App\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ResponseApi
{
    protected function respondWithCustomData($data, $status = 200): JsonResponse
    {
        return new JsonResponse([
            'data' => $data,
            'meta' => ['timestamp' => $this->getTimestampInMilliseconds()],
        ], $status);
    }

    /**
     * Return no content for delete requests
     */
    protected function respondWithNoContent(): JsonResponse
    {
        return new JsonResponse([
            'data' => null,
            'meta' => ['timestamp' => $this->getTimestampInMilliseconds()],
        ], Response::HTTP_NO_CONTENT);
    }

    /**
     * Return collection response from the application
     */
    protected function respondWithCollection(string $resourceCollection, LengthAwarePaginator|Collection $collection)
    {
        return (new $resourceCollection($collection))->additional(
            ['meta' => ['timestamp' => $this->getTimestampInMilliseconds()]]
        );
    }

    /**
     * Return single item response from the application
     */
    protected function respondWithItem(string $resourceItem, Model $item)
    {
        return (new $resourceItem($item))->additional(
            ['meta' => ['timestamp' => $this->getTimestampInMilliseconds()]]
        );
    }

    protected function getTimestampInMilliseconds(): int
    {
        return intdiv((int)now()->format('Uu'), 1000);
    }

    protected function respondWithCustomDataFromService($data, $status = 200)
    {
        return response($data, $status)->header('Content-Type', 'application/json');
    }
}
