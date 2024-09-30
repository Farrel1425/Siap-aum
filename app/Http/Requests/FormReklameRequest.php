<?php

namespace App\Http\Requests;

use App\Helpers\ResponseFormatter;
use App\Models\FormJenisIzin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class FormReklameRequest extends FormRequest
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
        $form_jenis_izin = FormJenisIzin::where('jenis_izin_id', 9)
        ->get();
        $rules = [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
        foreach ($form_jenis_izin as $form) {
            $rules[$form->kode_isian] = 'required';
            if ($form->tipe == 'date') {
                $rules[$form->kode_isian] = 'required|date:Y-m-d';
            }
        }
        unset($rules['NAMA_PERUSAHAAN']);
        unset($rules['HP/TELP']);
        unset($rules['ALAMAT']);
        return $rules;
    }

    public function failedValidation(Validator $validator)
    {
        return ResponseFormatter::failedValidation($validator->errors());
    }
}
