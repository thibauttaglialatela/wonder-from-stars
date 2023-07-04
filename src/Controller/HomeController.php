<?php

namespace App\Controller;

use App\Repository\MediaRepository;
use App\Repository\PictureRepository;
use App\Service\NasaApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/', name:'home_')]
class HomeController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(MediaRepository $mediaRepository, PictureRepository $pictureRepository): Response
    {
        $media = $mediaRepository->findOneBy(['name'=> 'image']);
        $image = $pictureRepository->findAll();
        $image = $pictureRepository->findOneBy(['Medias' => $media]);
//        dd($image);

        return $this->render('home/index.html.twig', [
            'image' => $image
        ]);
    }
}
