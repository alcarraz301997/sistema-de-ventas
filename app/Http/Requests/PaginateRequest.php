<?php

namespace App\Http\Requests;

use App\Constans\Error;
use App\Exceptions\ResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PaginateRequest extends FormRequest
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
            'page' => ['nullable', 'integer'],
            'per_page' => ['nullable', 'integer']
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'page' => $this->input('page', 1),
            'per_page' => $this->input('per_page', 10)
        ]);
    }

    public function failedValidation(Validator $validator)
    {
        throw new ResponseException(Error::CLIENT_ERROR, 'Formato inválido.', 'warning', $validator->errors());
    }
}
