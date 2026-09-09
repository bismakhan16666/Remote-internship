<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('id');
        
        return [
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|email|unique:students,email,' . $id,
            'age' => 'required|integer|min:1|max:100',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:m,f',
            'score' => 'nullable|integer|min:0|max:100',
            'status' => 'required|in:active,inactive,pending',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Student name is required.',
            'name.string' => 'Name must be a valid text.',
            'name.min' => 'Name must be at least 3 characters.',
            'name.max' => 'Name cannot be more than 255 characters.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered. Please use another email.',
            'age.required' => 'Age is required.',
            'age.integer' => 'Age must be a valid number.',
            'age.min' => 'Age must be at least 1.',
            'age.max' => 'Age cannot be more than 100.',
            'date_of_birth.required' => 'Date of birth is required.',
            'date_of_birth.date' => 'Please enter a valid date.',
            'date_of_birth.before' => 'Date of birth must be before today.',
            'gender.required' => 'Please select gender.',
            'gender.in' => 'Gender must be Male or Female.',
            'score.integer' => 'Score must be a number.',
            'score.min' => 'Score cannot be less than 0.',
            'score.max' => 'Score cannot be more than 100.',
            'status.required' => 'Please select status.',
            'status.in' => 'Status must be Active, Inactive or Pending.',
            'image.image' => 'Please upload a valid image file.',
            'image.mimes' => 'Image must be jpeg, png, jpg, or gif.',
            'image.max' => 'Image size cannot be more than 2MB.'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'Full Name',
            'email' => 'Email Address',
            'age' => 'Age',
            'date_of_birth' => 'Date of Birth',
            'gender' => 'Gender',
            'score' => 'Score',
            'status' => 'Status',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Trim whitespace from inputs
        $this->merge([
            'name' => trim($this->name),
            'email' => trim($this->email),
        ]);
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            redirect()->back()
                ->withErrors($validator)
                ->withInput()
        );
    }
}