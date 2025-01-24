<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'data' => $this->collection, // Formatted as specified in TaskResource
            'meta' => [ // My additional custom data
                'number_of_tasks' => $this->collection->count()
            ]
        ];
    }
}
