<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentRequest extends FormRequest
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
            'ktp' => ['extensions:jpeg,jpg,png,gif,bmp,tiff,webp|max:8192', 'image', 'nullable'],
            'kk' => ['extensions:jpeg,jpg,png,gif,bmp,tiff,webp|max:8192', 'image', 'nullable'],
            'foto_diri' => ['nullable', 'image', 'extensions:jpeg,jpg,png,gif,bmp,tiff,webp|max:8192'],
            // 'ijazah' => ['nullable', 'image', 'extensions:jpeg,png,gif,bmp,tiff,webp|max:8192'],
            // 'transkrip_nilai' => ['nullable', 'image', 'extensions:jpeg,png,gif,bmp,tiff,webp|max:8192'],

        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */

    public function messages(): array
    {
        return [
            'ktp.extensions' => 'KTP harus berupa file jpg atau png',
            'kk.extensions' => 'KK harus berupa file jpg atau png',
            'foto_diri.extensions' => 'Foto harus berupa file jpg atau png',
            // 'ijazah.extensions' => 'Ijazah harus berupa file jpg atau png',
            // 'transkrip_nilai.extensions' => 'Transkrip nilai harus berupa file jpg atau png',
        ];
    }
}
