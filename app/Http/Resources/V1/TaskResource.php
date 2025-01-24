<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id'                => $this->id,
            'assignee_name'     => $this->user()->first()->name,
            'assignee_id'       => $this->user_id,
            'created_by_name'   => $this->creatorUser()->first()->name,
            'created_by'        => $this->created_by,
            'title'             => $this->title,
            'description'       => $this->description,
            'status'            => $this->status,
            'due_date'          => $this->due_date,
            'task_dependencies' => $this->taskDependencies()->pluck('task_dependencies_pivot.dependency_id'),
            'created_at'        => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at'        => $this->updated_at->format('Y-m-d H:i:s')
        ];
    }
}
