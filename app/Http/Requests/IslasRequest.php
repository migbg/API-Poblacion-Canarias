<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IslasRequest extends FormRequest
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
        if ($this->has('desglosado')) {
            $this->merge([
                'desglosado' => filter_var($this->desglosado, FILTER_VALIDATE_BOOLEAN)
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $ageCheck = 'filled|integer|between:0,100';

        return [
            'nombre' => 'required|string',
            'desglosado' => 'filled|boolean',
            'edad' => $ageCheck,
            'edad_min' => $ageCheck . '|exclude_with:edad',
            'edad_max' => $ageCheck . '|exclude_with:edad',
            'periodo' => 'filled|integer|between:2021,2025',
            'sexo' => 'filled|in:M,m,F,f'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        $ageCheck = 'La edad debe ser un valor entre 0 y 100';

        return [
            'nombre' => 'La isla es obligatoria',
            'desglosado' => 'El parámetro desglosado debe ser equivalente a un booleano',
            'edad' => $ageCheck,
            'edad_min' => $ageCheck,
            'edad_max' => $ageCheck,
            'periodo' => 'Los periodos válidos son desde 2021 hasta 2025',
            'sexo' => 'El sexo debe ser M (hombres) o F (mujeres)'
        ];
    }
}