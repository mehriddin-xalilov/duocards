<?php

namespace App\Http\Requests\UserAnswer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserAnswerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'nullable|integer|min:-2147483648|max:2147483647|exists:users,id',
            'question_id' => 'nullable|integer|min:-2147483648|max:2147483647|exists:questions,id',
            'answer_id' => 'nullable|integer|min:-2147483648|max:2147483647|exists:answers,id',
            'is_correct' => 'nullable|boolean'
        ];
    }
}
