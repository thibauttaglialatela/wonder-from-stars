<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Entity\UserPicture;
use App\Form\PictureFormType;
use App\Repository\PictureRepository;
use App\Repository\UserRepository;
use App\Service\PictureUploader;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/picture', name: 'app_picture_')]
class PictureController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(PictureRepository $pictureRepository): Response
    {
        $images = $pictureRepository->findBy(['isValidated' => true]);


        return $this->render('picture/index.html.twig', [
            'images' => $images,
        ]);
    }

//    méthode permettant à un utilisateur enregistré d'ajouter une image
    #[Route('/add', name: 'add')]
    public function addPicture(Request                $request,
                               EntityManagerInterface $entityManager,
                               PictureUploader        $pictureUploader,
                               MailerInterface        $mailer,
                               UserRepository         $userRepository,
                               LoggerInterface        $logger
    ): Response
    {
        $this->denyAccessUnlessGranted('ACCESS_MODAL', null, 'Access denied.');

        $picture = new Picture();
        //ajout de la date à la création
        $picture->setDate(new \DateTime());
        //on récupére l'utilisateur connecté
        $user = $this->getUser();
        $userPicture = new UserPicture();
        $userPicture->setCollector($user);

        $form = $this->createForm(PictureFormType::class, $picture);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $pictureUploader->setUploadDir($this->getParameter('pictures_directory'));

            /** @var UploadedFile $pictureFile */
            $pictureFile = $form->get('pictureFile')->getData();
            if ($pictureFile) {
                $picture->setPictureFile($pictureFile, $pictureUploader);
                $userPicture->setPictureCollector($picture);
                $userPicture->setCreatedAt(new \DateTime());
            }

            // ... perform some action, such as saving the picture to the database
            $entityManager->persist($picture);
            $entityManager->persist($userPicture);
            $entityManager->flush();
            //envoie du mail à l'administrateur pour validation image
            $admins = $userRepository->findBy(['roles' => ['ROLE_ADMIN']]);
            $adminsEmails = [];
            foreach ($admins as $admin) {
                $adminsEmails[] = $admin->getEmail();
            }
            $email = (new TemplatedEmail())
                ->to(...$adminsEmails)
                ->subject('nouvelle photo à valider')
                ->htmlTemplate('emails/image_validation.html.twig');
            try {
                $mailer->send($email);
            } catch (TransportExceptionInterface $exception) {
                $logger->error("Une erreur s'est produite : " . $exception->getMessage());
            }


            return $this->redirectToRoute('home_index', [], 301);

        }

        return $this->render('picture/new.html.twig', [
            'form' => $form
        ]);
    }
    #[Route('/{id}', name: 'show')]
    public function showPicture(Picture $picture): Response
    {
        return $this->render('picture/show.html.twig', [
            'picture' => $picture
        ]);
    }
}
