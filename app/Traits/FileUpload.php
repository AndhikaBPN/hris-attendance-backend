<?php
namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Exception;

trait FileUpload
{
    protected $maxFileSize = 2048; // KB, adjust as needed

    /**
     * Validate file size.
     */
    protected function validateFileSize(UploadedFile $file)
    {
        return ($file->getSize() / 1024) <= $this->maxFileSize;
    }

    /**
     * Upload a file, replace if exists, and move to internal folder.
     *
     * @param UploadedFile $file
     * @param string $path
     * @param string|null $currentFile
     * @param string $disk
     * @return array
     */
    public function upload(UploadedFile $file, string $path, string $currentFile = null, string $disk = 'public')
    {
        try {
            // Validate file size
            if (!$this->validateFileSize($file)) {
                return [
                    'success' => false,
                    'message' => 'Ukuran file melebihi ' . $this->maxFileSize . 'KB'
                ];
            }

            // Delete existing file if provided
            if ($currentFile && Storage::disk($disk)->exists($currentFile)) {
                Storage::disk($disk)->delete($currentFile);
            }

            // Generate unique filename
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs($path, $filename, $disk);

            return [
                'success' => true,
                'path' => $filePath,
                'url' => Storage::url($filePath)
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}