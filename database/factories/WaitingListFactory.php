<?php

namespace Database\Factories;

use App\Models\WaitingList;
use Illuminate\Database\Eloquent\Factories\Factory;

class WaitingListFactory extends Factory
{
    protected $model = WaitingList::class;

    public function definition(): array
    {
        return [
            'player_name' => $this->faker->unique()->name(),
            'added_at' => now(),
            'removed_at' => null,
            'group_number' => $this->faker->numberBetween(1, 4),
        ];
    }
}
