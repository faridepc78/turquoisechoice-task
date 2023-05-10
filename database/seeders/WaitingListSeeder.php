<?php

namespace Database\Seeders;

use App\Models\WaitingList;
use App\Repositories\WaitingList\WaitingListRepositoryInterface;
use Illuminate\Database\Seeder;

class WaitingListSeeder extends Seeder
{
    public function run()
    {
        $waitingListRepository = resolve(WaitingListRepositoryInterface::class);

        if (!$waitingListRepository->getCount()) {
            WaitingList::factory(10)->create();
        } else {
            $this->command->warn('WaitingLists has already been created');
        }
    }
}
