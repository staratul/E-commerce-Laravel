<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'category_id' => 'required',
            'tags' => 'required',
            'sub_category_id' => 'required',
            'title' => 'required',
            'sub_title' => 'required',
            'states' => 'required',
            'original_price' => 'required',
            'discount' => 'required',
            'free_delivery_price' => 'required',
            'seller_name' => 'required',
            'total_in_stock' => 'required'
        ];
    }
}
