<?php

namespace App\Http\Requests\Test;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTestRequest extends BaseRequest
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
            'name' => 'nullable|string',
            'category_id' => 'nullable|integer|min:-2147483648|max:2147483647|exists:categories,id',
            'level_id' => 'nullable|integer|min:-2147483648|max:2147483647|exists:levels,id',
            'time_limit' => 'nullable|integer|min:-2147483648|max:2147483647',
            'questions_count' => 'nullable|integer|min:-2147483648|max:2147483647',
            'randomize_questions' => 'nullable|boolean',
            'randomize_answers' => 'nullable|boolean'
        ];
    }
}
