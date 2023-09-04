<?php

namespace App\Controller;

use App\Service\NasaApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarouselController extends AbstractController
{
    #[Route('/carousel', name: 'app_carousel')]
    public function index(NasaApiService $nasaApiService): Response
    {
        $imageArray = $nasaApiService->getSeveralPictures(10);
        //retirer les images ayant un copyright

        $imageWithoutCopyright = array_filter($imageArray, function ($image) {
            return !isset($image['copyright']) || $image['copyright'] === false;
        });
        //dd($imageWithoutCopyright);
        return $this->render('carousel/index.html.twig', [
            'images' => $imageWithoutCopyright,
        ]);
    }
}
