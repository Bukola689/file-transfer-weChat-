<?php
// app/Services/NotificationService.php
namespace App\Services;

use App\Mail\FileTransferNotification;
use App\Mail\FileDownloadedNotification;
use App\Models\FileTransfer;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    public function sendTransferNotifications(FileTransfer $transfer)
    {
        foreach ($transfer->recipients as $recipient) {
            Mail::to($recipient->email)->send(
                new FileTransferNotification($transfer, $recipient->email)
            );
        }
    }

    public function sendDownloadNotification(FileTransfer $transfer)
    {
        if ($transfer->notify_on_download) {
            Mail::to($transfer->sender_email)->send(
                new FileDownloadedNotification($transfer)
            );
        }
    }
}