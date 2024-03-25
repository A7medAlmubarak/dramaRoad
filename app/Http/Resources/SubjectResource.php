<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\TeacherResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
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
            'sessions_number' => $this->sessions_number,
            'full_mark' => $this->full_mark,
            'success_mark' => $this->success_mark,
            'fail_mark' => $this->fail_mark,
            'teacher' => new TeacherResource($this->teacher),
        ];

    }
}
