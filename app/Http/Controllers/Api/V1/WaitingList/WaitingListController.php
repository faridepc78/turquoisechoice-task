<?php

namespace App\Http\Controllers\Api\V1\WaitingList;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\WaitingList\DestroyWaitingListRequest;
use App\Http\Requests\Api\V1\WaitingList\IndexWaitingListRequest;
use App\Http\Requests\Api\V1\WaitingList\StoreWaitingListRequest;
use App\Http\Resources\Api\V1\WaitingList\WaitingListPaginateResource;
use App\Http\Resources\Api\V1\WaitingList\WaitingListResource;
use App\Repositories\WaitingList\WaitingListRepositoryInterface;

class WaitingListController extends Controller
{
    protected WaitingListRepositoryInterface $waitingListRepository;

    public function __construct(WaitingListRepositoryInterface $waitingListRepository)
    {
        $this->waitingListRepository = $waitingListRepository;
    }

    public function index(IndexWaitingListRequest $request)
    {
        $waiting_lists = $this->waitingListRepository
            ->filterPaginate(
                $request->input('per_page', 10),
                $request->input('group_number'),
                $request->input('with_trashed')
            );

        return WaitingListPaginateResource::make($waiting_lists);
    }

    public function store(StoreWaitingListRequest $request)
    {
        $group_number = $this->waitingListRepository->calculateGroupNumber();

        $request->merge([
            'group_number' => $group_number,
            'added_at' => now(),
        ]);

        $waiting_list = $this->waitingListRepository
            ->create(filterNullData($request->validationData()));

        return $this->success_response(
            WaitingListResource::make($waiting_list),
            'waiting_list has been successfully created'
        );
    }

    public function destroy(DestroyWaitingListRequest $request)
    {
        $player_name = $request->input('player_name');

        $player = $this->waitingListRepository->checkPlayerName($player_name);
        if ($player) {
            $player->removed_at = now();
            $player->save();

            return $this->success_response(null, 'waiting_list has been deleted');
        }

        return $this->error_response(400, 'player is not exist');
    }
}
