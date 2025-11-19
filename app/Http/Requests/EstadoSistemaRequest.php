<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EstadoSistemaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tabla' => ['required', 'string', 'max:50'],
            'codigo' => ['required', 'string', 'max:50'],
            'nombre' => ['required', 'string', 'max:100'],
            'descripcion' => ['nullable', 'string'],
            'color' => ['nullable', 'string', 'max:7'],
            'es_final' => ['nullable', 'bool'],
            'orden' => ['nullable', 'int4'],
            'activo' => ['nullable', 'bool'],
            'creado' => ['nullable', 'date_format:Y-m-d\TH:i:s'],
        ];
    }

    public function messages(): array
    {
        return [
            //'tabla' => '',
            //'codigo' => '',
            //'nombre' => '',
            //'descripcion' => '',
            //'color' => '',
            //'es_final' => '',
            //'orden' => '',
            //'activo' => '',
            //'creado' => '',
        ];
    }
}
