<?php

namespace App\Http\Requests\UserTestSession;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserTestSessionRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|min:-2147483648|max:2147483647|exists:users,id',
            'test_id' => 'required|integer|min:-2147483648|max:2147483647|exists:tests,id',
            'started_at' => 'nullable|date',
            'finished_at' => 'nullable|date',
            'score' => 'required|integer|min:-2147483648|max:2147483647',
            'correct_answers' => 'required|integer|min:-2147483648|max:2147483647',
            'wrong_answers' => 'required|integer|min:-2147483648|max:2147483647',
            'status' => 'required|integer|min:-2147483648|max:2147483647'
        ];
    }
}
