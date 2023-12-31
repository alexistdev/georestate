<?php

namespace App\Http\Requests\Agen;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyRequest extends FormRequest
{
    /**
     * Author: AlexistDev
     * Email: Alexistdev@gmail.com
     * Phone: 082371408678
     * Github: https://github.com/alexistdev
     */

    public function authorize(): bool
    {
        if (!Request::routeIs('agn.*')) {
            return false;
        }
        return Auth::check();
    }


    public function rules()
    {
        if (in_array($this->method(), ['DELETE'])) {
            $rules = [
                'kabupaten_id' => 'required|max:255',
            ];
        }else if(in_array($this->method(), ['PATCH'])){
            $rules = [
                'name' => 'required|max:255',
                'description' => 'nullable|max:1000',
                'lt' => 'required|numeric',
                'lb' => 'required|numeric',
                'price' => 'required|numeric',
                'kategori' => 'required|max:255',
                'feature1' => 'nullable|max:255',
                'feature2' => 'nullable|max:255',
                'feature3' => 'nullable|max:255',
                'feature4' => 'nullable|max:255',
            ];
        }else{
            $rules = [
                'name' => 'required|max:255',
                'description' => 'nullable|max:1000',
                'lt' => 'required|numeric',
                'lb' => 'required|numeric',
                'price' => 'required|numeric',
                'kategori' => 'required|max:255',
                'feature1' => 'nullable|max:255',
                'feature2' => 'nullable|max:255',
                'feature3' => 'nullable|max:255',
                'feature4' => 'nullable|max:255',
                'kecamatan' => 'required|max:255',
                'provinsi' => 'required|max:255',
                'kabupaten' => 'required|max:255',
                'address' => 'nullable|max:255',
            ];
        }
        return $rules;
    }

    public function messages()
    {
        if (in_array($this->method(), ['DELETE'])) {
            $message = [
                'provinsi_id.required' => "ID tidak ditemukan silahkan refresh halaman!",
                'provinsi_id.numeric' => "ID tidak ditemukan silahkan refresh halaman!",
            ];
        }else if(in_array($this->method(), ['PATCH'])){
            $message = [
                'name.required' => "Nama Listing/Property wajib diisi!",
                'name.max' => "Panjang karakter maksimal yang diperbolehkan adalah 255 karakter!",
                'description.max' => "Panjang karakter maksimal yang diperbolehkan adalah 1000 karakter!",
                'lt.required' => "Wajib diisi!",
                'lt.numeric' => "Harus berupa angka !",
                'lb.required' => "Wajib diisi!",
                'lb.numeric' => "Harus berupa angka !",
                'price.required' => "Wajib diisi!",
                'price.numeric' => "Harus berupa angka !",
                'kategori.required' => "Wajib dipilih!",
                'kategori.max' => "Wajib dipilih !",
                'feature1.max' => "Panjang karakter maksimal yang diperbolehkan adalah 255 karakter!",
                'feature2.max' => "Panjang karakter maksimal yang diperbolehkan adalah 255 karakter!",
                'feature3.max' => "Panjang karakter maksimal yang diperbolehkan adalah 255 karakter!",
                'feature4.max' => "Panjang karakter maksimal yang diperbolehkan adalah 255 karakter!",
            ];
        } else {
            $message = [
                'name.required' => "Nama Listing/Property wajib diisi!",
                'name.max' => "Panjang karakter maksimal yang diperbolehkan adalah 255 karakter!",
                'description.max' => "Panjang karakter maksimal yang diperbolehkan adalah 1000 karakter!",
                'lt.required' => "Wajib diisi!",
                'lt.numeric' => "Harus berupa angka !",
                'lb.required' => "Wajib diisi!",
                'lb.numeric' => "Harus berupa angka !",
                'price.required' => "Wajib diisi!",
                'price.numeric' => "Harus berupa angka !",
                'kategori.required' => "Wajib dipilih!",
                'kategori.max' => "Wajib dipilih !",
                'feature1.max' => "Panjang karakter maksimal yang diperbolehkan adalah 255 karakter!",
                'feature2.max' => "Panjang karakter maksimal yang diperbolehkan adalah 255 karakter!",
                'feature3.max' => "Panjang karakter maksimal yang diperbolehkan adalah 255 karakter!",
                'feature4.max' => "Panjang karakter maksimal yang diperbolehkan adalah 255 karakter!",
                'kecamatan.required' => "Kecamatan wajib diisi!",
                'kecamatan.max' => "Kecamatan wajib diisi!",
                'provinsi.required' => "Provinsi wajib diisi!",
                'provinsi.max' => "Provinsi wajib diisi!",
                'kabupaten.required' => "Kabupaten wajib diisi!",
                'kabupaten.max' => "Kabupaten wajib diisi!",
                'address.max' => "Panjang karakter maksimal yang diperbolehkan adalah 255 karakter!",
            ];
        }
        return $message;
    }
}
