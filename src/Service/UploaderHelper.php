<?php

namespace App\Service;

use Gedmo\Sluggable\Util\Urlizer;

use Psr\Log\LoggerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Asset\Context\RequestStackContext;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use function PHPUnit\Framework\throwException;

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
        }else{
            throw new Exception('il ne s\'agit ni de AUTEUR ni OUVERAGE entity' );
        }
        $originalFileName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $newFileName = $originalFileName . '-' . uniqid() . '.' . $uploadedFile->guessExtension();
        $uploadedFile->move($destination, $newFileName);

        return $newFileName;
    }

}
