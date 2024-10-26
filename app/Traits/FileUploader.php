<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

trait FileUploader
{
    /**
     * Upload a file to the specified storage disk and directory.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param string $disk
     * @return string The file path on success
     */
    public function uploadFile(UploadedFile $file, string $directory, string $disk = 'public'): string
    {
        // Generate a unique file name
        $filename = time() . '_' . $file->getClientOriginalName();

        // Store the file on the specified disk and directory
        return $file->storeAs($directory, $filename, $disk);
    }

    /**
     * Delete a file from the specified storage disk.
     *
     * @param string $path
     * @param string $disk
     * @return bool
     */
    public function deleteFile(string $path, string $disk = 'public'): bool
    {
        return Storage::disk($disk)->exists($path) && Storage::disk($disk)->delete($path);
    }

    /**
     * Update a file by replacing the old file with the new file upload.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param string|null $oldFilePath
     * @param string $disk
     * @return string
     */
    public function updateFile(UploadedFile $file, string $directory, ?string $oldFilePath, string $disk = 'public'): string
    {
        if ($oldFilePath) {
            $this->deleteFile($oldFilePath, $disk);
        }
        return $this->uploadFile($file, $directory, $disk);
    }
}
