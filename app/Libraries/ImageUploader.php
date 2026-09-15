<?php

namespace App\Libraries;

use CodeIgniter\HTTP\Files\UploadedFile;

class ImageUploader
{
    private const ALLOWED_MIME_TYPES = ['image/jpeg', 'image/png', 'image/webp'];
    private const MAX_SIZE_MB = 2;

    public function upload(?UploadedFile $file, string $directory): string|false|null
    {
        if (!$file || $file->getError() === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if (!$file->isValid() || $file->hasMoved() || !in_array($file->getMimeType(), self::ALLOWED_MIME_TYPES, true) || $file->getSizeByUnit('mb') > self::MAX_SIZE_MB) {
            return false;
        }

        $path = FCPATH . 'uploads/' . trim($directory, '/\\');
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        $fileName = $file->getRandomName();
        $file->move($path, $fileName);

        return $fileName;
    }

    public function delete(?string $directory, ?string $fileName): void
    {
        if (!$directory || !$fileName) {
            return;
        }

        $path = FCPATH . 'uploads/' . trim($directory, '/\\') . '/' . basename($fileName);
        if (is_file($path)) {
            unlink($path);
        }
    }
}
