<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubTaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            // 'task_id' => $this->task_id,
            'task' => new TaskResource($this->whenLoaded('task')),
            'body' => $this->body,
            'priority' => $this->priority,
            'is_completed' => $this->is_completed,
            'task_date' => $this->task_date,
        ];
    }
}
