<?php

namespace App\Services;

use App\Models\Recipient;
use Illuminate\Support\Facades\Log;

class FileTransferService
{

     public function createTransfer(array $data, array $files, $user = null)
    {
        // Create the transfer
        $transfer = FileTransfer::create([
            'user_id' => $user ? $user->id : null,
            'sender_email' => $data['sender_email'],
            'subject' => $data['subject'],
            'message' => $data['message'] ?? null,
            'password' => isset($data['password']) ? bcrypt($data['password']) : null,
            'expires_at' => now()->addDays($data['expires_in']),
            'download_limit' => $data['download_limit'] ?? null,
            'notify_on_download' => $data['notify_on_download'] ?? false
        ]);

        // Store files
        $this->storeFiles($transfer, $files);

        // Add recipients
        $this->addRecipients($transfer, $data['recipients']);

        return $transfer;
    }

    protected function storeFiles(FileTransfer $transfer, array $files)
    {
        foreach ($files as $uploadedFile) {
            $path = $uploadedFile->store('transfers/' . $transfer->uuid, 'public');
            
            $transfer->files()->create([
                'name' => $uploadedFile->getClientOriginalName(),
                'path' => $path,
                'mime_type' => $uploadedFile->getMimeType(),
                'size' => $uploadedFile->getSize()
            ]);
        }
    }

    protected function addRecipients(FileTransfer $transfer, string $recipients)
    {
        $emails = array_map('trim', explode(',', $recipients));
        
        foreach ($emails as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $transfer->recipients()->create(['email' => $email]);
            }
        }
    }

    public function deleteTransfer(FileTransfer $transfer)
    {
        // Delete files from storage
        foreach ($transfer->files as $file) {
            Storage::disk('public')->delete($file->path);
        }

        $transfer->delete();
    }

    public function recordDownload(FileTransfer $transfer, array $downloadData)
    {
        $transfer->downloads()->create([
            'ip_address' => $downloadData['ip_address'],
            'user_agent' => $downloadData['user_agent'] ?? null
        ]);

        $transfer->increment('downloads');

        // Mark recipient as downloaded if applicable
        if (isset($downloadData['recipient_email'])) {
            $transfer->recipients()
                     ->where('email', $downloadData['recipient_email'])
                     ->update(['has_downloaded' => true]);
        }

        return $transfer;
    }

    
    /**
     * Update the recipient's download status.
     *
     * @param int $recipientId
     * @param bool $hasDownloaded
     * @return Recipient|null
     */
    public function updateRecipientDownloadStatus(int $recipientId, bool $hasDownloaded): ?Recipient
    {
        try {
            $recipient = Recipient::findOrFail($recipientId);
            $recipient->has_downloaded = $hasDownloaded;
            $recipient->save();

            return $recipient;
        } catch (\Exception $e) {
            Log::error('Failed to update recipient download status', [
                'recipient_id' => $recipientId,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }
}