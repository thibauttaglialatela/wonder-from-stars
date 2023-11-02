<?php

namespace App\Controller;

use App\Service\NasaApiService;
use App\Validator\DateNotInFuture;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarouselController extends AbstractController
{
    #[Route('/carousel', name: 'app_carousel')]
    public function index(NasaApiService $nasaApiService, Request $request): Response
    {
        // ajout d'un formulaire dans la page pour récupérer la date

        $defaultData = [];
        $form = $this->createFormBuilder($defaultData)
            ->add('start_date', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/yyyy',
                'constraints' => [
                    new DateNotInFuture(),
                ],
            ])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $startDate = $data['start_date']->format('Y-m-d');
        }
        if (isset($startDate)) {
            $imageArray = $nasaApiService->getSeveralPictures($startDate);

            // retirer les images ayant un copyright
            $imageWithoutCopyright = array_filter($imageArray, function ($image) {
                return !isset($image['copyright']) || false === $image['copyright'];
            });
        } else {
            $imageToday = [];
            $imageWithoutCopyright = $imageToday;
        }

        // dd($imageWithoutCopyright);
        return $this->render('carousel/index.html.twig', [
            'images' => $imageWithoutCopyright,
            'form' => $form->createView(),
        ]);
    }
}
