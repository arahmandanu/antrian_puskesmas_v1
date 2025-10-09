<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // ubah ke false kalau mau pakai policy
    }

    public function rules(): array
    {
        $poliId = $this->route('poli')->id ?? null;

        return [
            'code'           => [
                'required',
                'string',
                'max:1',
                Rule::unique('rooms', 'code')->ignore($poliId),
            ],
            'name'           => 'required|string|max:255',
            'lantai'         => 'required|integer|in:' . implode(',', range(1, config('mysite.total_lantai'))),
            'show'           => 'required|boolean',
            'dependencies'   => 'array|max:1',
            'dependencies.*' => 'integer|exists:rooms,id',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required'         => 'Kode wajib diisi.',
            'code.max'              => 'Kode hanya boleh 1 huruf.',
            'code.unique'           => 'Kode sudah digunakan.',
            'name.required'         => 'Nama ruangan wajib diisi.',
            'lantai.required'       => 'Lantai wajib diisi.',
            'lantai.in'             => 'Nomor lantai tidak valid.',
            'show.required'         => 'Status tampil wajib diisi.',
            'dependencies.max'      => 'Hanya boleh memilih satu dependency.',
            'dependencies.*.exists' => 'Dependency tidak ditemukan.',
        ];
    }
}
