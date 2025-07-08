<?php

namespace App\Services;

use App\Models\Recipient;
use Carbon\Carbon;
use App\Models\FileTransfer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FileTransferService
{

     public function createTransfer(array $data, array $files, $user = null)
    {
        // Create the transfer
        $transfer = FileTransfer::create([
            'user_id' => auth()->id(),
            'sender_email' => $data['sender_email'],
            'subject' => $data['subject'],
            'message' => $data['message'] ?? null,
            'password' => isset($data['password']) ? bcrypt($data['password']) : null,
            'expires_at' => Carbon::now()->addDays($data['expires_in_days'] ?? 7),
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
        Storage::disk('public')->deleteDirectory('transfers/' . $transfer->uuid);
        $transfer->delete();
    }

    public function findByUuid(string $uuid)
    {
        return FileTransfer::where('uuid', $uuid)->firstOrFail();
    }

    public function findByUuidWithRelations(string $uuid, array $relations)
    {
        return FileTransfer::with($relations)
            ->where('uuid', $uuid)
            ->firstOrFail();
    }

    public function getAllTransfersPaginated(int $perPage = 20)
    {
        return FileTransfer::with(['user', 'files', 'downloads', 'recipients'])
            ->latest()
            ->paginate($perPage);
    }

    public function verifyPassword(FileTransfer $transfer, string $password)
    {
        return \Hash::check($password, $transfer->password);
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

}