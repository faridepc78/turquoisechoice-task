<?php

namespace App\Http\Requests\Api\V1\WaitingList;

use Illuminate\Foundation\Http\FormRequest;

class IndexWaitingListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:5', 'max:50'],
            'group_number' => ['nullable', 'integer', 'between:1,4'],
            'with_trashed' => ['required', 'boolean'],
        ];
    }
}
