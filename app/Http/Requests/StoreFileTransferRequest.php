<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFileTransferRequest extends FormRequest
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
            'user_id' => 'nullable|exists:users,id',
            'sender_email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'nullable|string|max:1000',
            'password' => 'nullable|string|min:6|max:255',
            'expires_at' => 'required|date|after_or_equal:now',
            'download_limit' => 'nullable|integer|min:1',
            'notify_on_download' => 'boolean',
        ];
    }
}
