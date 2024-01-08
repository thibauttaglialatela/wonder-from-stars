<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class PictureUploader
{
    private $targetDirectory;
    private $slugger;

    public function __construct(string $targetDirectory, SluggerInterface $slugger)
    {
        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
    }

    public function addPicture(UploadedFile $file, string $uploadDir = null): string
    {
        // Use the specified upload directory if provided, otherwise use the default targetDirectory
        $targetDirectory = $uploadDir ?? $this->targetDirectory;

        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

        try {
            $file->move($targetDirectory, $fileName);
        } catch (FileException $e) {
            // Handle the exception if needed
        }

        return $fileName;
    }

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }

    // Ajoutez cette méthode pour définir dynamiquement le répertoire d'envoi
    public function setUploadDir(string $uploadDir)
    {
        $this->targetDirectory = $uploadDir;
    }
}
