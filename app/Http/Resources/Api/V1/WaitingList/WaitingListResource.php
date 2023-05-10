<?php

namespace App\Http\Resources\Api\V1\WaitingList;

use Illuminate\Http\Resources\Json\JsonResource;

class WaitingListResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'player_name' => $this->player_name,
            'added_at' => $this->added_at->format('Y-m-d H:i:s'),
            'removed_at' => optional($this->removed_at)->format('Y-m-d H:i:s'),
            'group_number' => $this->group_number,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
