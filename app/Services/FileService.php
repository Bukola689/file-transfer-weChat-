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

    if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
        return response()->json(['error' => 'Could not create ZIP archive'], 500);
    }

    foreach ($transfer->files as $file) {
        $filePath = storage_path("app/public/{$file->storage_path}");

        // 🔒 Only add if file exists
        if (file_exists($filePath)) {
            $zip->addFile($filePath, $file->original_name);
        }
    }

    $zip->close();

    // ✅ Confirm the zip file was actually created
    if (!file_exists($zipPath)) {
        return response()->json(['error' => 'ZIP file could not be found'], 500);
    }

    // 🧹 Optional: Add download logging here if needed

    return response()->download($zipPath)->deleteFileAfterSend(true);
   }
}