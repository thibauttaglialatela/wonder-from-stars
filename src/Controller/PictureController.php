<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Form\PictureFormType;
use App\Repository\PictureRepository;
use App\Service\PictureUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[Route('/picture', name: 'app_picture_')]
class PictureController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(PictureRepository $pictureRepository): Response
    {
        $images = $pictureRepository->findAll();

        return $this->render('picture/index.html.twig', [
            'images' => $images,
        ]);
    }

//    méthode permettant à un utilisateur enregistré d'ajouter une image
#[IsGranted('ROLE_USER')]
#[Route('/add', name: 'add')]
    public function addPicture(Request $request, EntityManagerInterface $entityManager, PictureUploader $pictureUploader): Response
{
    $picture = new Picture();
    //ajout de la date à la création
    $picture->setDate(new \DateTime());

    $form = $this->createForm(PictureFormType::class, $picture);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        /** @var UploadedFile $pictureFile */
        $pictureFile = $form->get('pictureFile')->getData();
        if ($pictureFile) {
            $pictureFileName = $pictureUploader->addPicture($pictureFile);
            $picture->setPictureFilename($pictureFileName);
        }


        $picture = $form->getData();
        // ... perform some action, such as saving the picture to the database
        $entityManager->persist($picture);
        $entityManager->flush();

        return $this->redirectToRoute('app_picture_index', [], 301);

    }

    return $this->render('picture/_new.html.twig', [
        'form' => $form
    ]);
}
}
