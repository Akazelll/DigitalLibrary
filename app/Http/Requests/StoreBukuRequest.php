<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBukuRequest extends FormRequest
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
            'judul_buku'    => 'required|string|max:255',
            'id_penerbit'   => 'required|exists:penerbit,id',
            'kategori_id'   => 'nullable|exists:kategori,id',
            'tahun_terbit'  => 'required|digits:4|integer|min:1900',
            'jml_halaman'   => 'required|integer|min:1',
            'stok'          => 'required|integer|min:0',
            'sampul'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ];
    }
}
