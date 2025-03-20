<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class ImageService
{
    public function uploadProfileImage(UploadedFile $image, string $userId): array
    {
        // Store original image
        $fileName = $userId . '_' . time() . '.' . $image->getClientOriginalExtension();
        $profileImagePath = $image->storeAs('profiles', $fileName, 'public');

        // Generate and store thumbnail
        $thumbnailPath = 'profiles/thumbnails/' . $fileName;
        $this->createThumbnail($image, storage_path('app/public/' . $thumbnailPath), 150);

        return [
            'profile_image' => $profileImagePath,
            'thumbnail'     => $thumbnailPath,
        ];
    }

    private function createThumbnail(UploadedFile $image, string $savePath, int $width)
    {
        list($originalWidth, $originalHeight) = getimagesize($image->getRealPath());
        $height = ($width / $originalWidth) * $originalHeight;

        // Create image
        $source = imagecreatefromjpeg($image->getRealPath());
        $thumb = imagecreatetruecolor($width, $height);

        // Resize
        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $width, $height, $originalWidth, $originalHeight);
        imagejpeg($thumb, $savePath, 90);

        imagedestroy($source);
        imagedestroy($thumb);
    }
}
