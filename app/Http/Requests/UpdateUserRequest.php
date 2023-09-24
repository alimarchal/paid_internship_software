<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'fathers_name' => 'required|string|max:255',
            'date_of_birth' => [
                'required',
                'date', // Ensure that the input is a valid date
                'before_or_equal:' . now()->subYears(18)->format('Y-m-d'), // Must be 18 years or older
                'after_or_equal:' . now()->subYears(25)->format('Y-m-d'),  // Must be less than 25 years
            ],
            'nationality' => 'required|string',
            'gender' => 'required|string',
            'cnic_number' => 'required|string|max:15', // You may adjust the max length according to your requirements.
            'marital_status' => 'required|string',
            'district' => 'required|string',
            'district_of_domicile' => 'required|string',
            'contact_number' => 'required|string|max:15', // You may adjust the max length according to your requirements.
            'religion' => 'required|string',
            'mailing_address' => 'required|string',
            'profile_pic_1' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096', // Adjust the allowed file types and max size as needed.
            'cnic_front' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096', // Adjust the allowed file types and max size as needed.
            'cnic_back' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096', // Adjust the allowed file types and max size as needed.
        ];
    }
}
