<?php

namespace App\Http\Requests\Product;

use App\Constans\Error;
use App\Exceptions\ResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'sku' => 'required|unique:products,sku|string|max:20',
            'name' => 'required|string|max:100',
            'unit_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'sku.unique' => 'El SKU ya está registrado.',
            'unit_price.min' => 'El precio debe ser un número positivo.',
            'stock.min' => 'El stock debe ser un valor igual o mayor a cero.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new ResponseException(Error::CLIENT_ERROR, 'Formato inválido.', 'warning', $validator->errors());
    }
}
