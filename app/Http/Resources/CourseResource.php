<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'levels_number' => $this->when($this->levels_number, $this->levels_number, '1'),
            'online_status' => $this->when($this->online_status, 'Online', 'Offline'),
            'registration_start_date' => $this->registration_start_date,
            'registration_end_date' => $this->when($this->registration_end_date, $this->registration_end_date),
            'payments' => $this->payments,
            'students_number' => $this->students_number,
            'creator_id' => $this->creator_id,
            'creator_name' => $this->creator->name,
            'publish_status' => $this->publish_status,
            'finished_status' => $this->finished_status,
        ];
    }
}
