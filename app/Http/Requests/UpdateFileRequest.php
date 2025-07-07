<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
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
            // Additional rules can be added here if needed
            // For example, if you want to validate the file size:
             'size' => 'required|integer|min:1|max:10485760', // 10MB max
             'mime_type' => 'required|string|in:image/jpeg,image/png,application/pdf,application/zip',
             'path' => 'required|string|regex:/^[\w,\-]+\.(jpg|jpeg|png|pdf|zip)$/i',
             'name' => 'required|string|regex:/^[\w,\-]+\.(jpg|jpeg|png|pdf|zip)$/i',
             'size' => 'required|integer|min:1|max:10485760', // 10MB max
             'mime_type' => 'required|string|in:image/jpeg,image/png,application/pdf,application/zip' 
        ];
    }
}
