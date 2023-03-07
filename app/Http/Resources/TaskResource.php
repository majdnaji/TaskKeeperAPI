<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id"=>$this->id,
            "title"=>$this->title,
            "department_id"=>$this->department_id,
            "project_id"=>$this->project_id,
            "department"=>$this->whenLoaded('department'),
            "status"=>$this->status,
            "deadline"=>$this->deadline
        ];
    }
}
