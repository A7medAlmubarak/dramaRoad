<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ModeratorResource extends JsonResource
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
            'salary' => $this->salary,
            'employment_date' => $this->employment_date,
            'resignation_date' => $this->resignation_date,
            'vacations' => $this->vacations,
            'rewards' => $this->rewards,
            'user' => new UserResource($this->user),
        ];
    }
}
