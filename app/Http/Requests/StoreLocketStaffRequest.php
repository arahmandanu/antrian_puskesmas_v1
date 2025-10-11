<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enum\LocketList;
use App\Models\LocketStaff;

class StoreLocketStaffRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Sesuaikan jika hanya admin boleh membuat data
        return true;
    }

    public function rules(): array
    {
        return [
            'staff_name' => 'required|string|max:255',
            'lantai' => 'required|integer|in:' . implode(',', range(1, config('mysite.total_lantai'))),
            'locket_number' => 'required|unique:locket_staff,locket_number|integer|in:' . implode(',', (new LocketStaff)->availableLocket()),
            'allowed_codes' => 'required|array|min:1',
            'allowed_codes.*' => 'string|in:' . implode(',', array_map(fn($case) => $case->value, LocketList::cases())),
        ];
    }

    public function messages(): array
    {
        return [
            // 🔹 staff_name
            'staff_name.required' => 'Nama petugas harus diisi.',
            'staff_name.string' => 'Nama petugas harus berupa teks.',
            'staff_name.max' => 'Nama petugas tidak boleh lebih dari 255 karakter.',

            // 🔹 lantai
            'lantai.required' => 'Nomor lantai wajib diisi.',
            'lantai.integer' => 'Nomor lantai harus berupa angka.',
            'lantai.in' => 'Nomor lantai yang dipilih tidak valid.',

            // 🔹 locket_number
            'locket_number.required' => 'Nomor loket wajib diisi.',
            'locket_number.unique' => 'Nomor loket ini sudah digunakan oleh petugas lain.',
            'locket_number.integer' => 'Nomor loket harus berupa angka.',
            'locket_number.in' => 'Nomor loket yang dipilih tidak tersedia.',

            // 🔹 allowed_codes
            'allowed_codes.required' => 'Pilih minimal satu jenis antrian yang bisa dilayani.',
            'allowed_codes.array' => 'Data kode antrian harus dalam bentuk array.',
            'allowed_codes.min' => 'Harus ada minimal satu kode antrian yang dipilih.',
            'allowed_codes.*.string' => 'Setiap kode antrian harus berupa teks.',
            'allowed_codes.*.in' => 'Salah satu kode antrian yang dipilih tidak valid.',
        ];
    }
}
