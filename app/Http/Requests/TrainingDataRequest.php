<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrainingDataRequest extends FormRequest
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
            'name' => 'required|string|unique:training_data,name',
            'class' => 'required|exists:class_labels,id',
            'attribute.*' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'class.exists' => 'Class does not exist, please select the appropriate class',
        ];
    }
}
