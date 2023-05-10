<?php

namespace App\Repositories\WaitingList;

use App\Repositories\Contracts\BaseRepositoryInterface;

interface WaitingListRepositoryInterface extends BaseRepositoryInterface
{
    public function filterPaginate(int $per_page, ?int $group_number, bool $with_trashed);

    public function checkPlayerName(string $player_name);

    public function calculateGroupNumber();
}
