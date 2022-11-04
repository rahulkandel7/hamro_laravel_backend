<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderRequest extends FormRequest
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
            'shipping_id' => 'required',
            'cart_id' => 'required',
            'coupon_id' => 'nullable',
            'coupon_amount' => 'nullable',
            'delivery_charge' => 'required',
            'shipping_address' => 'required',
            'fullname' => 'required',
            'phone' => 'required',
            'payment' => 'nullable',
            'status' => 'nullable',
            'cancel_reason' => 'nullable',
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
