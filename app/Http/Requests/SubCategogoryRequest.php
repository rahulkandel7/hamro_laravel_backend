<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SubCategogoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'subcategory_name' => 'required',
            'category_id' => 'required',
            'priority' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'subcategory_name.required' => 'Please Provide Sub Category Name',
            'category_id.required' => 'Please Choose Category',
            'priority.required' => 'Please Provide Priority',
        ];
    }

    // protected function failedValidation(Validator $validator)
    // {
    //     $errors = $validator->errors();

    //     $response = response()->json([
    //         'message' => 'Invalid data send',
    //         'details' => $errors->messages(),
    //     ], 422);

    //     throw new HttpResponseException($response);
    // }
}
