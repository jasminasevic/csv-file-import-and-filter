<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportCsvFileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'file' => 'required|file|mimes:csv,xml,xlsx'
        ];
    }

    public function messages(){
        return [
            'file.required' => 'File is required',
            'file.file' => 'File should be uploaded',
            'file.mimes' => 'File should have .csv, .xml or .xslx extension',
        ];
    }
}
