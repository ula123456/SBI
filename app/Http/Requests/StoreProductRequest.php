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
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            return [
        'name' => 'required|string|min:2',
        'price' => 'required|numeric|min:0', // цена не может быть отрицательной
        'barcode' => [
            'required',
            'string',
            'size:13', // EAN-13 – 13 символов
            'unique:products,barcode',
            'regex:/^\d{13}$/', // только цифры, 13 штук
        ],
        'category_id' => 'required|exists:categories,id', // категория должна существовать
    ];
        ];
    }
}
