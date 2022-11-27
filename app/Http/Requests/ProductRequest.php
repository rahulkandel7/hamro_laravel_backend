<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::user()->role == "admin") {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'category_id' => 'required',
            'sub_category_id' => 'nullable',
            'sku' => 'required|unique:products',
            'brand_id' => 'required',
            'price' => 'required',
            'stock' => 'numeric|min:1',
            'name' => 'required',
            'color' => 'required',
            'size' => 'required',
            'discountedPrice' => 'nullable',
            'flashsale' => 'nullable',
            'description' => 'required',
            'available' => 'nullable',
            'photopath1' => 'nullable|image|mimes:png,jpg,jpeg',
            'photopath2' => 'nullable|image|mimes:png,jpg,jpeg',
            'photopath3' => 'nullable|image|mimes:png,jpg,jpeg',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        $response = response()->json([
            'message' => 'Invalid data send',
            'details' => $errors->messages(),
            'status' => false,
        ], 422);

        throw new HttpResponseException($response);
    }
}
