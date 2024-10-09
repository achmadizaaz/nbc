<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestingDataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:testing_data,name',
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
