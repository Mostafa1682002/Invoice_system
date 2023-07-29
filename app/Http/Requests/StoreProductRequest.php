<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'product_name' => 'required|unique:products',
            'description' => 'required',
            'section_id' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'product_name.required' => 'يرجي ادخال اسم المنتج',
            'product_name.unique' => 'هذاالمنتج موجود مسبقا',
            'description.required' => 'هذا الحقل مطلوب',
            'section_id.required' => 'يرجي ادخال اسم القسم'
        ];
    }
}
