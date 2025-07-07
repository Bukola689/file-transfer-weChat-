<?php

// app/Services/FileService.php
namespace App\Services;

use App\Models\File;
use App\Models\FileTransfer;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class FileService
{
    public function downloadFile(File $file)
    {
        return Storage::disk('public')->download(
            $file->storage_path,
            $file->original_name
        );
    }

    public function downloadAsZip(FileTransfer $transfer)
    {
        $zipFileName = "transfer_{$transfer->uuid}.zip";
        $zipPath = storage_path("app/public/temp/{$zipFileName}");

        // Ensure temp directory exists
        if (!file_exists(dirname($zipPath))) {
            mkdir(dirname($zipPath), 0755, true);
        }

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            foreach ($transfer->files as $file) {
                $filePath = storage_path("app/public/{$file->storage_path}");
                $zip->addFile($filePath, $file->original_name);
            }
            $zip->close();
        }

        return response()->download($zipPath)->deleteFileAfterSend();
    }
}