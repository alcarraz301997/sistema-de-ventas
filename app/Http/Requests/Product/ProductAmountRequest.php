<?php

namespace App\Http\Requests\Product;

use App\Constans\Error;
use App\Exceptions\ResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ProductAmountRequest extends FormRequest
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
            'amount' => 'required|integer|min:1'
        ];
    }

    public function messages(): array
    {
        return [
            'amount' => 'El monto debe ser mayor a 0'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new ResponseException(Error::CLIENT_ERROR, 'Formato inválido.', 'warning', $validator->errors());
    }
}
