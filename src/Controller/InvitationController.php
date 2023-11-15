<?php

namespace App\Controller;

use App\Entity\Invitation;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class InvitationController extends AbstractController
{
    public function __construct(private readonly UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    #[Route('/invitation/{uuid}', name: 'app_invitation')]
    public function register(Invitation $invitation, Request $request, EntityManagerInterface $entityManager): Response
    {
        if (null !== $invitation->getReader()) {
            throw new \Exception('This invitation has already been used');
        }
        $user = new User();
        $user->setEmail($invitation->getEmail());
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles(['ROLE_USER']);
            $invitation->setReader($user);

            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('notice', 'bravo vous êtes inscrit');

            return $this->redirectToRoute('home_index');
        }

        return $this->render('registration/register.html.twig', [
            'registration_form' => $form->createView(),
        ]);
    }
}
