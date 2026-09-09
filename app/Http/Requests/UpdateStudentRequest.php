<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
{
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
            'status' => 'required|in:active,inactive,pending'
        ];
    }

    public function messages()
    {
        return [
            // All custom messages
        ];
    }
}