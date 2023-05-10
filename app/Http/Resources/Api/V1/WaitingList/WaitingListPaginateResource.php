<?php

namespace App\Http\Resources\Api\V1\WaitingList;

use Illuminate\Http\Resources\Json\ResourceCollection;

class WaitingListPaginateResource extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'status' => 'Success',
            'message' => 'list of waiting_lists by paginate',
            'code' => 200,
            'data' => $this->collection->map(function ($item) {
                return [
                    'id' => $item->id,
                    'player_name' => $item->player_name,
                    'added_at' => $item->added_at,
                    'removed_at' => $item->removed_at,
                    'group_number' => $item->group_number,
                    'created_at' => $item->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $item->updated_at->format('Y-m-d H:i:s'),
                ];
            }),
        ];
    }
}
