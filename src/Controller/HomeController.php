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
        $filteredImage = null;

        if (isset($image['media_type']) && $image['media_type'] === 'image') {
            if (!isset($image['copyright']) || empty($image['copyright'])) {
                $filteredImage = $image;
            }
        }

        return $this->render('home/index.html.twig', [
            'image' => $filteredImage,
        ]);
    }
}
