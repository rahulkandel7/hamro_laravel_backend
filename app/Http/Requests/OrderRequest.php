<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'area_id' => 'required',
            'cart_id' => 'required',
            'delivery_charge' => 'required',
            'shipping_address' => 'required',
            'fullname' => 'required',
            'phone' => 'required',
            'payment' => 'nullable',
            'status' => 'nullable',
            'cancel_reason' => 'nullable',
        ];
    }
}
