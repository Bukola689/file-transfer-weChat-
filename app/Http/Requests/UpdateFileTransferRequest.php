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
            // Additional rules can be added here if needed
            // For example, if you want to validate the transfer status:
            'status' => 'nullable|string|in:pending,completed,cancelled',
            'created_at' => 'nullable|date',
            'updated_at' => 'nullable|date',
            'deleted_at' => 'nullable|date',
            'notification_sent' => 'boolean', // If you want to track if a notification
            'transfer_id' => 'required|exists:file_transfers,id', // If you want to ensure the transfer ID is valid
            'file_count' => 'nullable|integer|min:0', // If you want to track the number of files in the transfer
            'total_size' => 'nullable|integer|min:0', // If you want to track the
        ];
    }
}
