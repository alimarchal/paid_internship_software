<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRandomUserQuestionRequest extends FormRequest
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
            'question_id' => 'required',
            'answer_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'question_id.required' => 'The question is required.', // Custom message for the question_id
            'answer_id.required' => 'An answer must be selected before saving...', // Custom message for the answer_id
        ];
    }
}
