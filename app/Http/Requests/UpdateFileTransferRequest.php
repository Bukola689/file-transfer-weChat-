<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFileTransferRequest extends FormRequest
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
            'sender_email' => 'required|email',
            'recipients' => 'required|string',
            'subject' => 'required|max:100',
            'message' => 'nullable',
            'files' => 'required|array|min:1',
            'files.*' => 'file|max:102400', // 100MB max per file
            'expires_in' => 'required|in:1,3,7,14,30',
            'password' => 'nullable|min:4',
            'download_limit' => 'nullable|integer|min:1',
            'notify_on_download' => 'boolean'
        ];
    }
}
