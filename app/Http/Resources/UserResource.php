<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'create_dates' => [
                'creadted_at_human' => $this->created_at->diffForHumans(),
                'creadted_at' => $this->created_at,
            ],
            'projects' => ProjectResource::collection($this->whenLoaded('projects')),
            'tasks' => TaskResource::collection($this->whenLoaded('tasks'))
        ];
    }
}
