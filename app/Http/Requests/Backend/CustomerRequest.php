<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'credit_limit' => ($this->credit_limit !== null && $this->credit_limit !== '') ? $this->credit_limit : 0,
            'opening_balance' => ($this->opening_balance !== null && $this->opening_balance !== '') ? $this->opening_balance : 0,
            'balance_type' => $this->balance_type ?? 'dr',
            'status' => $this->status ?? 'active',
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $customerId = $this->route('customer') ? $this->route('customer')->id : null;

        return [
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15|unique:customers,mobile,' . $customerId,
            'email' => 'nullable|email|max:255',
            'gst_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:10',
            'credit_limit' => 'nullable|numeric|min:0',
            'opening_balance' => 'nullable|numeric|min:0',
            'balance_type' => 'nullable|in:dr,cr',
            'status' => 'nullable|in:active,inactive',
        ];
    }
}
