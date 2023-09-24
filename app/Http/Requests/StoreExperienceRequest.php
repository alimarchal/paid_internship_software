<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExperienceRequest extends FormRequest
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
            'organization' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'government_private' => 'required|boolean', // Assumes it's a boolean field (1 or 0).
            'monthly_salary' => 'nullable|numeric',
            'starting_date' => 'required|date',
            'ending_date' => 'required|date|after_or_equal:starting_date',
            'reason_of_leaving' => 'nullable|string',
            'experience_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096', // Adjust the allowed file types and max size as needed.
            'relieving_letter' => 'nullable|file|mimes:pdf,doc,docx|max:4096', // Adjust the allowed file types and max size as needed.

        ];
    }
}
