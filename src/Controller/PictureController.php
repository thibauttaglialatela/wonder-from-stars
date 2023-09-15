<?php

namespace App\Controller;

use App\Repository\PictureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PictureController extends AbstractController
{
    #[Route('/picture', name: 'app_picture')]
    public function index(PictureRepository $pictureRepository): Response
    {
        $images = $pictureRepository->findAll();
        return $this->render('picture/index.html.twig', [
            'images' => $images
        ]);
    }
}
