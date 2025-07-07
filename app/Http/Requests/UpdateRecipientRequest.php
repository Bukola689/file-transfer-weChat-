<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRecipientRequest extends FormRequest
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
            'email' => 'required|email|max:255',
            'has_downloaded' => 'boolean',
            // Additional rules can be added here if needed
            // For example, if you want to validate the recipient's status:
            'status' => 'nullable|string|in:pending,completed,cancelled',
            'downloaded_at' => 'nullable|date|after_or_equal:now',
            'expires_at' => 'nullable|date|after_or_equal:now',
            'notification_sent' => 'boolean', // If you want to track if a notification
        ];
    }
}
