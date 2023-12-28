<?php

namespace App\Http\Requests\Admin\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KabupatenRequest extends FormRequest
{
    /**
     * Author: AlexistDev
     * Email: Alexistdev@gmail.com
     * Phone: 082371408678
     * Github: https://github.com/alexistdev
     */

    public function authorize(): bool
    {
        if (!Request::routeIs('adm.*')) {
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
                'kabupaten_id' => 'required|max:255',
                'provinsi_id' => 'required|max:255',
                'code' => 'required|max:125',
                'name' => 'required|max:255',
            ];
        }else{
            $rules = [
                'provinsi_id' => 'required|max:255',
                'code' => 'required|max:125',
                'name' => 'required|max:255',
            ];
        }
        return $rules;
    }

    public function messages()
    {
        if (in_array($this->method(), ['DELETE'])) {
            $message = [
                'kabupaten_id.required' => "ID tidak ditemukan silahkan refresh halaman!",
                'kabupaten_id.max' => "ID tidak ditemukan silahkan refresh halaman!",
            ];
        }else if(in_array($this->method(), ['PATCH'])){
            $message = [
                'kabupaten_id.required' => "ID tidak ditemukan, silahkan refresh halaman atau login ulang!",
                'kabupaten_id.max' => "ID tidak ditemukan, silahkan refresh halaman atau login ulang!",
                'provinsi_id.required' => "Silahkan pilih Provinsi terlebih dahulu!",
                'provinsi_id.max' => "Silahkan pilih Provinsi terlebih dahulu!",
                'code.required' => "Code wajib diisi!",
                'code.max' => "Panjang karakter maksimal yang diperbolehkan adalah 125 karakter!",
                'name.required' => "Nama kelas wajib diisi!",
                'name.max' => "Panjang karakter maksimal yang diperbolehkan adalah 255 karakter!",
            ];
        } else {
            $message = [
                'provinsi_id.required' => "Silahkan pilih Provinsi terlebih dahulu!",
                'provinsi_id.max' => "Silahkan pilih Provinsi terlebih dahulu!",
                'code.required' => "Code wajib diisi!",
                'code.max' => "Panjang karakter maksimal yang diperbolehkan adalah 125 karakter!",
                'name.required' => "Nama kelas wajib diisi!",
                'name.max' => "Panjang karakter maksimal yang diperbolehkan adalah 255 karakter!",
            ];
        }
        return $message;
    }
}
