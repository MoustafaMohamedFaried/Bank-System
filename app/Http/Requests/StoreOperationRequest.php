<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOperationRequest extends FormRequest
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
        return [
            "operation_name" => "required",
            "amount" => "required|numeric",
        ];
    }
    public function messages(): array
    {
        return [
            "operation_name.required" => "Please choose the operation type",

            "amount.required" => "Please enter amount",
            "amount.numeric" => "Please enter amount numric",
        ];
    }
}
