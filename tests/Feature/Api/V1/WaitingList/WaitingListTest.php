<?php

namespace Api\V1\WaitingList;

use App\Models\WaitingList;
use Database\Seeders\UserSeeder;
use Database\Seeders\WaitingListSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WaitingListTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_user_can_not_see_all_waiting_lists_by_wrong_page()
    {
        $this->makeDataTables();

        $params = [
            'page' => 'test',
            'with_trashed' => 1,
        ];

        $this->getJson(route('api.v1.waiting_lists.index', $params))
            ->assertStatus(422);
    }

    public function test_user_can_not_see_all_waiting_lists_by_page_less_than_1()
    {
        $this->makeDataTables();

        $params = [
            'page' => 0,
            'with_trashed' => 1,
        ];

        $this->getJson(route('api.v1.waiting_lists.index', $params))
            ->assertStatus(422);
    }

    public function test_user_can_not_see_all_waiting_lists_by_wrong_per_page()
    {
        $this->makeDataTables();

        $params = [
            'per_page' => 'test',
            'with_trashed' => 1,
        ];

        $this->getJson(route('api.v1.waiting_lists.index', $params))
            ->assertStatus(422);
    }

    public function test_user_can_not_see_all_waiting_lists_by_per_page_less_than_5()
    {
        $this->makeDataTables();

        $params = [
            'per_page' => 2,
            'with_trashed' => 1,
        ];

        $this->getJson(route('api.v1.waiting_lists.index', $params))
            ->assertStatus(422);
    }

    public function test_user_can_not_see_all_waiting_lists_by_per_page_greater_than_50()
    {
        $this->makeDataTables();

        $params = [
            'per_page' => 100,
            'with_trashed' => 1,
        ];

        $this->getJson(route('api.v1.waiting_lists.index', $params))
            ->assertStatus(422);
    }

    public function test_user_can_not_see_all_waiting_lists_by_wrong_group_number()
    {
        $this->makeDataTables();

        $params = [
            'group_number' => 0,
            'with_trashed' => 0,
        ];

        $this->getJson(route('api.v1.waiting_lists.index', $params))
            ->assertStatus(422);
    }

    public function test_user_can_not_see_all_waiting_lists_by_group_number_less_than_1()
    {
        $this->makeDataTables();

        $params = [
            'group_number' => 0,
            'with_trashed' => 0,
        ];

        $this->getJson(route('api.v1.waiting_lists.index', $params))
            ->assertStatus(422);
    }

    public function test_user_can_not_see_all_waiting_lists_by_group_number_greater_than_4()
    {
        $this->makeDataTables();

        $params = [
            'group_number' => 5,
            'with_trashed' => 0,
        ];

        $this->getJson(route('api.v1.waiting_lists.index', $params))
            ->assertStatus(422);
    }

    public function test_user_can_not_see_all_waiting_lists_without_with_trashed()
    {
        $this->makeDataTables();

        $params = [
            'per_page' => 10,
        ];

        $this->getJson(route('api.v1.waiting_lists.index', $params))
            ->assertStatus(422);
    }

    public function test_user_can_not_see_all_waiting_lists_by_wrong_with_trashed()
    {
        $this->makeDataTables();

        $params = [
            'per_page' => 10,
            'with_trashed' => 'test',
        ];

        $this->getJson(route('api.v1.waiting_lists.index', $params))
            ->assertStatus(422);
    }

    public function test_user_can_see_all_waiting_lists()
    {
        $this->makeDataTables();

        $params = [
            'page' => 1,
            'per_page' => 10,
            'with_trashed' => 0,
        ];

        $this->getJson(route('api.v1.waiting_lists.index', $params))
            ->assertSuccessful()
            ->assertStatus(200);
    }

    public function test_user_can_not_store_waiting_lists_without_player_name()
    {
        $data = [];

        $this->postJson(route('api.v1.waiting_lists.store', $data))
            ->assertStatus(422);

        $this->assertEquals(0, WaitingList::count());
    }

    public function test_user_can_not_store_waiting_lists_with_repetitive_player_name()
    {
        $data = [
            'player_name' => 'farid',
        ];

        $this->postJson(route('api.v1.waiting_lists.store', $data))
            ->assertSuccessful()
            ->assertStatus(200);

        $this->postJson(route('api.v1.waiting_lists.store', $data))
            ->assertStatus(422);

        $this->assertEquals(1, WaitingList::count());
    }

    public function test_user_can_store_waiting_lists()
    {
        $data = [
            'player_name' => 'farid',
        ];

        $this->postJson(route('api.v1.waiting_lists.store', $data))
            ->assertSuccessful()
            ->assertStatus(200);

        $this->assertEquals(1, WaitingList::count());
    }

    public function test_user_can_not_delete_waiting_lists_without_player_name()
    {
        $this->createWaitingList();

        $data = [];

        $this->deleteJson(route('api.v1.waiting_lists.destroy', $data))
            ->assertStatus(422);

        $this->assertEquals(1, WaitingList::count());
    }

    public function test_user_can_not_delete_waiting_lists_by_full_removed_at()
    {
        $waiting_list = $this->createWaitingList();

        $data = [
            'player_name' => $waiting_list->player_name,
        ];

        $this->deleteJson(route('api.v1.waiting_lists.destroy', $data))
            ->assertSuccessful()
            ->assertStatus(200);

        $this->assertEquals(1, WaitingList::count());

        $this->deleteJson(route('api.v1.waiting_lists.destroy', $data))
            ->assertStatus(400);
    }

    public function test_user_can_delete_waiting_lists()
    {
        $waiting_list = $this->createWaitingList();

        $data = [
            'player_name' => $waiting_list->player_name,
        ];

        $this->deleteJson(route('api.v1.waiting_lists.destroy', $data))
            ->assertSuccessful()
            ->assertStatus(200);

        $this->assertEquals(1, WaitingList::count());
    }

    private function makeDataTables()
    {
        $this->seed([
            UserSeeder::class,
            WaitingListSeeder::class,
        ]);
    }

    private function createWaitingList()
    {
        return WaitingList::factory()->create();
    }
}
