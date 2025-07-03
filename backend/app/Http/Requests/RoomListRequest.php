<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date' => 'date|nullable',
            'dates' => 'array|nullable',
            'dates.*' => 'date',
            'start' => 'date|nullable',
            'end' => 'date|nullable',
        ];
    }
} 