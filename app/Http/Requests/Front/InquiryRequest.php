<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class InquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'nullable|string|max:30',
            'message' => 'required|string|max:2000',
            // Honeypot anti-spam: field tersembunyi, harus kosong.
            'website' => 'prohibited',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => "Nama wajib diisi!",
            'email.required' => "Email wajib diisi!",
            'email.email' => "Format email tidak valid!",
            'phone.max' => "Nomor telepon maksimal 30 karakter!",
            'message.required' => "Pesan wajib diisi!",
            'message.max' => "Pesan maksimal 2000 karakter!",
            'website.prohibited' => "Pesan tidak dapat dikirim.",
        ];
    }
}
