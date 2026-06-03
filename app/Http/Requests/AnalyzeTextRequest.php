<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnalyzeTextRequest extends FormRequest
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
            'input_text' => [
                'required',
                'string',
                'min:2',
                'max:500',
                // Regex memastikan setidaknya mengandung beberapa huruf Arab
                'regex:/[\x{0600}-\x{06FF}]/u'
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'input_text.required' => 'Teks Arab wajib diisi.',
            'input_text.regex' => 'Input harus berupa tulisan/huruf Arab.',
            'input_text.max' => 'Panjang teks maksimal adalah 500 karakter.',
        ];
    }
}
