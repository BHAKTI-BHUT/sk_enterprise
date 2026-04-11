<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
        $supplierId = $this->route('supplier') ? $this->route('supplier')->id : null;

        return [
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'mobile' => 'required|unique:suppliers,mobile,' . $supplierId . '|digits:10',
            'email' => 'nullable|email|max:255',
            'gst_number' => 'nullable|string|max:50',
            'pan_number' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:10',
            'status' => 'required|in:active,inactive',
            'credit_limit' => 'nullable|numeric|min:0',
            'payment_terms' => 'nullable|integer|min:0',
            'opening_balance' => 'nullable|numeric|min:0',
            'balance_type' => 'nullable|in:dr,cr',
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:50',
            'ifsc_code' => 'nullable|string|max:20',
            'upi_id' => 'nullable|string|max:100',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Supplier name is required.',
            'mobile.required' => 'Mobile number is required.',
            'mobile.unique' => 'Mobile number already exists.',
            'mobile.digits' => 'Mobile number must be 10 digits.'
        ];
    }
}
