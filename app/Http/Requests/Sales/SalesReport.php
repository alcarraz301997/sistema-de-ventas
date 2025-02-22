<?php

namespace App\Http\Requests\Sales;

use App\Constans\Error;
use App\Exceptions\ResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class SalesReport extends FormRequest
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
            'start_date' => 'nullable|date|before_or_equal:end_date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            'format'     => 'required|string|in:json,xlsx'
        ];
    }

    public function messages(): array
    {
        return [
            'start_date.date' => 'La fecha de inicio debe ser una fecha válida.',
            'end_date.date'   => 'La fecha de fin debe ser una fecha válida.',
            'start_date.before_or_equal' => 'La fecha de inicio no puede ser posterior a la fecha de fin.',
            'end_date.after_or_equal'    => 'La fecha de fin no puede ser anterior a la fecha de inicio.',
            'format.in' => 'Formato incorrecto.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new ResponseException(Error::CLIENT_ERROR, 'Formato inválido.', 'warning', $validator->errors());
    }
}
