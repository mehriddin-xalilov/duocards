<?php

namespace App\Http\Requests\Answer;

use App\Http\Requests\BaseRequest;

class UpdateAnswerRequest extends BaseRequest
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
            'question_id' => 'nullable|integer|min:-2147483648|max:2147483647|exists:questions,id',
            'answer_text' => 'nullable|string',
            'is_correct' => 'nullable|boolean',
            'type' => 'nullable|integer|min:-2147483648|max:2147483647'
        ];
    }
}
