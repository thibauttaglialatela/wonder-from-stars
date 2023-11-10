<?php

namespace App\Controller;

use App\Service\NasaApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'home_')]
class HomeController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(NasaApiService $nasaApiService): Response
    {
        $image = $nasaApiService->getApod();
        if (isset($image['media_type']) && 'image' === $image['media_type']) {
            $filteredImage = $image;
        } else {
            $filteredImage = [];
        }

        return $this->render('home/index.html.twig', [
            'image' => $filteredImage,
        ]);
    }
}
