<?php

namespace App\Http\Requests\Question;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
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
            'level_id' => 'required|integer|min:-2147483648|max:2147483647|exists:levels,id',
            'category_id' => 'required|integer|min:-2147483648|max:2147483647|exists:categories,id',
            'question_text' => 'required|string',
            'type' => 'nullable|integer'
        ];
    }
}
