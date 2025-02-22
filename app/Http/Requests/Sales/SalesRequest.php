<?php

namespace App\Http\Requests\Sales;

use App\Constans\Error;
use App\Exceptions\ResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class SalesRequest extends FormRequest
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
            'code' => 'required|unique:sales,code|string|max:20',
            'customer_name' => 'required|string|max:100',
            'customer_id_type' => 'required|string|in:DNI,PASAPORTE,CEDULA',
            'customer_id_number' => 'required|string|max:20',
            'customer_email' => 'required|email|max:100',
            "sale_date" => 'required|date',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1'
        ];
    }

    public function messages(): array
    {
        return [
            'customer_name.required' => 'El nombre del cliente es obligatorio.',
            'customer_id_type.required' => 'El tipo de identificación es obligatorio.',
            'customer_id_number.required' => 'El número de identificación es obligatorio.',
            'customer_email.required' => 'El correo electrónico es obligatorio.',
            'products.required' => 'Debe seleccionar al menos un producto.',
            'products.*.product_id.required' => 'El ID del producto es obligatorio.',
            'products.*.product_id.exists' => 'El producto seleccionado no existe.',
            'products.*.quantity.required' => 'La cantidad es obligatoria.',
            'products.*.quantity.min' => 'La cantidad debe ser al menos 1.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new ResponseException(Error::CLIENT_ERROR, 'Formato inválido.', 'warning', $validator->errors());
    }
}
