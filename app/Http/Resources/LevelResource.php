<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LevelResource extends JsonResource
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
            'start_date' => $this->when($this->start_date, $this->start_date),
            'end_date' => $this->when($this->end_date, $this->end_date),
            'shift_type' => $this->when(
                $this->shift_type == 1,
                'morning',
                $this->when(
                    $this->shift_type == 2,
                    'afternoon',
                    $this->when(
                        $this->shift_type == 3,
                        'evening',
                    )
                )
            ),
            'school_schedule' => $this->school_schedule,
            'level_number' => $this->level_number,
            'course_id' => $this->course_id,
            'finished_status' => $this->finished_status,
        ];
    }
}
