<?php

namespace App\Controller;

use App\Service\NasaApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/', name:'home_')]
class HomeController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(NasaApiService $nasaApiService): Response
    {
        $data = $nasaApiService->getApod();


        return $this->render('home/index.html.twig', [
            'datas' => $data
        ]);
    }
}
