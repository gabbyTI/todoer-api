<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'body' => $this->body,
            'priority' => $this->priority,
            'is_completed' => $this->is_completed ? true : false,
            'task_start_date' => $this->task_start_date,
            'task_end_date' => $this->task_end_date,
            'sub_task_count' => $this->subTasks->count(),
            'sub_tasks' => SubTaskResource::collection($this->subTasks),
            // 'create_dates' => [
            //     'creadted_at_human' => $this->created_at->diffForHumans(),
            //     'creadted_at' => $this->created_at,
            // ],
        ];
    }
}
