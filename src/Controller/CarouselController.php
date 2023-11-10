<?php

namespace App\Controller;

use App\Form\NasaSearchFormType;
use App\Service\NasaApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarouselController extends AbstractController
{
    #[Route('/carousel', name: 'app_carousel', methods: ['GET', 'POST'])]
    public function index(NasaApiService $nasaApiService, Request $request): Response
    {
        $form = $this->createForm(NasaSearchFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $startDate = $data['start_date']->format('Y-m-d');
            $imageArray = $nasaApiService->getSeveralPictures($startDate);

            $imageWithoutCopyright = array_filter($imageArray, function ($image) {
                // Vérifier si media_type est "image" et s'il n'y a pas de copyright
                return isset($image['media_type']) && 'image' === $image['media_type'] &&
                    (!isset($image['copyright']) || false === $image['copyright']);
            });

            return $this->render('carousel/_images.html.twig', [
                'image_without_copyright' => $imageWithoutCopyright,
            ]);
        }

        return $this->render('carousel/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
