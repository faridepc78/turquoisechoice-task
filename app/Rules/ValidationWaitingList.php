<?php

namespace App\Rules;

use App\Repositories\WaitingList\WaitingListRepositoryInterface;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidationWaitingList implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $waitingListRepository = resolve(WaitingListRepositoryInterface::class);

        $player = $waitingListRepository->checkPlayerName($value);

        if ($player) {
            $fail('the player is not exist');
        }
    }
}
