<?php

namespace App\Http\Requests;

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
            'title' => 'required|min:5',
            'sku' => 'required|min:3',
            'marca' => 'required|min:2',
            'procedencia' => 'required|min:2',
            'modelo' => 'required|min:2',
            'moneda' => 'required|min:2',
            'precio' => 'required',
            'description' => 'required|min:2',
            'cont_envio' => 'required|min:2',
        ];
    }
}
