<?php

namespace App\Http\Requests\UserTestAnswer;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserTestAnswerRequest extends BaseRequest
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
            'session_id' => 'required|integer|min:-2147483648|max:2147483647|exists:user_test_sessions,id',
            'test_id' => 'required|integer|min:-2147483648|max:2147483647|exists:tests,id',
            'question_id' => 'required|integer|min:-2147483648|max:2147483647|exists:questions,id',
            'answer_id' => 'nullable|integer|min:-2147483648|max:2147483647|exists:answers,id',
            'is_correct' => 'required|boolean',
            'answered_at' => 'nullable|date'
        ];
    }
}
