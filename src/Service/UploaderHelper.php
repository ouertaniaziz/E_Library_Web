<?php

namespace App\Service;

use Gedmo\Sluggable\Util\Urlizer;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Asset\Context\RequestStackContext;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploaderHelper
{
    const AUTEUR = 'auteurs_photo';
    const OUVERAGE = 'ouverages_image';
    private string $uploadPath;
    public function __construct(string $uploadPath)
    {
        $this->uploadPath = $uploadPath;
    }

    public function uploadFile(UploadedFile $uploadedFile, $entity): string
    {
        if($entity == 'AUTEUR'){
            $destination = $this->uploadPath.'/'.self::AUTEUR;
        }
        elseif ($entity == 'OUVERAGE'){
            $destination = $this->uploadPath.'/'.self::OUVERAGE;
        }

        $originalFileName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $newFileName = $originalFileName . '-' . uniqid() . '.' . $uploadedFile->guessExtension();
        $uploadedFile->move($destination, $newFileName);

        return $newFileName;
    }

}
