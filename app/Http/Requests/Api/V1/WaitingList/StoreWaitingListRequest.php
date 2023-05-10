<?php

namespace App\Http\Requests\Api\V1\WaitingList;

use App\Rules\ValidationWaitingList;
use Illuminate\Foundation\Http\FormRequest;

class StoreWaitingListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'player_name' => ['required', 'string', 'max:255', new ValidationWaitingList()],
        ];
    }
}
