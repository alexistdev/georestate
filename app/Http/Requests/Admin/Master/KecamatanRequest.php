<?php

namespace App\Http\Requests\Admin\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KecamatanRequest extends FormRequest
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
                'kecamatan_id' => 'required|max:255',
            ];
        }else if(in_array($this->method(), ['PATCH'])){
            $rules = [
                'kecamatan_id' => 'required|max:255',
                'kabupaten_id' => 'required|max:255',
                'name' => 'required|max:255',
            ];
        }else{
            $rules = [
                'kabupaten_id' => 'required|max:255',
                'name' => 'required|max:255',
            ];
        }
        return $rules;
    }

    public function messages()
    {
        if (in_array($this->method(), ['DELETE'])) {
            $message = [
                'kecamatan_id.required' => "ID tidak ditemukan silahkan refresh halaman!",
                'kecamatan_id.max' => "ID tidak ditemukan silahkan refresh halaman!",
            ];
        }else if(in_array($this->method(), ['PATCH'])){
            $message = [
                'kecamatan_id.required' => "ID tidak ditemukan, silahkan refresh halaman atau login ulang!",
                'kecamatan_id.max' => "ID tidak ditemukan, silahkan refresh halaman atau login ulang!",
                'kabupaten_id.required' => "Silahkan pilih Kabupaten terlebih dahulu!",
                'kabupaten_id.max' => "Silahkan pilih Kabupaten terlebih dahulu!",
                'name.required' => "Nama Kecamatan wajib diisi!",
                'name.max' => "Panjang karakter maksimal yang diperbolehkan adalah 255 karakter!",
            ];
        } else {
            $message = [
                'kabupaten_id.required' => "Silahkan pilih Kabupaten terlebih dahulu!",
                'kabupaten_id.max' => "Silahkan pilih Kabupaten terlebih dahulu!",
                'name.required' => "Nama Kecamatan wajib diisi!",
                'name.max' => "Panjang karakter maksimal yang diperbolehkan adalah 255 karakter!",
            ];
        }
        return $message;
    }
}
