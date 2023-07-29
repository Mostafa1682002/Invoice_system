<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
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
            "invoice_number" => ['required', 'unique:invoices'],
            "invoice_date" => ['required'],
            "due_date" => ['required'],
            "section_id" => ['required'],
            "product" => ['required'],
            "amount_commission" => ['required'],
        ];
    }
    public function messages()
    {
        return [
            "invoice_number.required" => 'رقم الفاتوره مطلوب',
            "invoice_number.unique" => "هذا الرقم موجود مسبقا برجاء ادخال رقم اخر",
            "invoice_date.required" => "تاريخ الفاتوره مطلوب",
            "due_date.required" => "تاريخ الاستحقاق مطلوب",
            "section_id.required" => "اسم القسم مطلوب",
            "product.required" => "اسم المنتج مطلوب",
            "amount_commission.required" => "مبلغ العموله مطلوب",
        ];
    }
}
