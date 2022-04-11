<?php

namespace App\Service;

use Gedmo\Sluggable\Util\Urlizer;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Asset\Context\RequestStackContext;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploaderHelper
{

    private string $uploadPath;
    public function __construct(string $uploadPath)
    {
        $this->uploadPath = $uploadPath;
    }

    public function uploadFile(UploadedFile $uploadedFile, ): string
    {
        $destination = $this->uploadPath.'/auteurs_photo';
        $originalFileName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $newFileName = $originalFileName . '-' . uniqid() . '.' . $uploadedFile->guessExtension();
        $uploadedFile->move($destination, $newFileName);

        return $newFileName;
    }

}
