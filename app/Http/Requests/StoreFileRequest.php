<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFileRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
           'transfer_id' => 'required|exists:file_transfers,id',
          'name' => 'required|string|max:255',
          'path' => 'required|string|max:255',
          'mime_type' => 'required|string|max:255',
          'size' => 'required|integer|min:1',
        ];
    }
}
