<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MarkResource extends JsonResource
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
            'subject name' => $this->subject->name,
            'level' => $this->subject->level->name,
            'course' => $this->subject->level->course->name,
            'mark' => $this->mark,
            'date' => $this->date,
        ];
    }
}
