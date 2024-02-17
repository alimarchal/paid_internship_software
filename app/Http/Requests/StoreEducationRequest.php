<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEducationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'education_level' => 'required|string',
            'board_university_name' => 'required|string|max:255',
            'passing_year' => 'required|integer|min:1900|max:' . date('Y'),
            'total_marks_cgpa' => 'required|string|max:255',
            'obtain_marks_cgpa' => 'required|string|max:255',
            'division' => 'required|string',
            'major_subject' => 'required|string',
            'degree_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096', // Adjust the allowed file types and max size as needed.
        ];
    }
}
