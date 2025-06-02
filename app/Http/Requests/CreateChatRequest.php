<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateChatRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('api')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'participant_ids' => 'required|array|min:1',
            'participant_ids.*' => 'integer|exists:users,id|distinct',

            'messages' => 'required|array|min:1',
            'messages.*.sender_id' => 'required|integer|exists:users,id',
            'messages.*.receiver_id' => 'required|integer|exists:users,id',
            'messages.*.message' => 'required|string|max:1000',
        ];
    }
}
