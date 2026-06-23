<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MarkEntryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'marks' => 'required|numeric|min:0|max:100',
        ];
    }
}
