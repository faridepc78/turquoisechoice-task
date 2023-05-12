<?php

namespace App\Repositories\WaitingList;

use App\Models\WaitingList;
use App\Repositories\Contracts\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class WaitingListRepository extends BaseRepository implements WaitingListRepositoryInterface
{
    public Model $model;

    public function __construct(WaitingList $model)
    {
        $this->model = $model;
    }

    public function filterPaginate(int $per_page, ?int $group_number, bool $with_trashed): LengthAwarePaginator
    {
        return $this->model::query()
            ->when($with_trashed, function (Builder $query) {
                return $query->whereNotNull('removed_at');
            })
            ->when($group_number, function (Builder $query) use ($group_number) {
                return $query->where('group_number', '=', $group_number);
            })
            ->orderBy('id')
            ->paginate($per_page);
    }

    public function checkPlayerName(string $player_name): Model|Builder|null
    {
        return $this->model::query()
            ->where('player_name', '=', $player_name)
            ->whereNull('removed_at')
            ->first();
    }

    public function calculateGroupNumber()
    {
        $lastPlayer = $this->model::query()->
        whereNull('removed_at')
            ->orderBy('id', 'desc')
            ->first();

        $groupNumber = 1;
        if ($lastPlayer) {
            if ($lastPlayer->group_number < 4) {
                $groupNumber = $lastPlayer->group_number + 1;
            }
        }

        return $groupNumber;
    }
}
