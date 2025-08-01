<?php

namespace App\Services;

use App\Models\FileTransfer;
use App\Services\FileService;
use App\Services\FileTransferService;
use App\Services\NotificationService;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadService
{
    protected $fileService;
    protected $transferService;
    //protected $notificationService;

    public function __construct(
        FileService $fileService,
        FileTransferService $transferService
        //NotificationService $notificationService
    )
     {
        $this->fileService = $fileService;
        $this->transferService = $transferService;
       // $this->notificationService = $notificationService;
    }

    public function handleDownload(FileTransfer $transfer, array $data)
    {

        if (!$transfer->canBeDownloaded()) {
            return response()->json(['This transfer is no longer available'], 403);
        }

        $this->transferService->recordDownload($transfer, $data);
        //$this->notificationService->sendDownloadNotification($transfer);

        if ($transfer->files->count() === 1) {
            return $this->fileService->downloadFile($transfer->files->first());
        }

        if ($transfer->hasReachedDownloadLimit()) {
              return response()->json([
              'error' => 'Download limit reached'
             ], 403);
          }

        return $this->fileService->downloadAsZip($transfer);
    }
}