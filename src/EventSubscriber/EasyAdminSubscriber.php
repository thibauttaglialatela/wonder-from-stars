<?php

namespace App\EventSubscriber;

use App\Entity\Invitation;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Uid\Uuid;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setUuid'],
        ];
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function setUuid(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if ($entity instanceof Invitation) {
            $entity->setUuid(Uuid::v4());
            // envoyer un email à l'utilisateur
            $email = (new TemplatedEmail())
                ->from('master.yoda@jedi.com')
                ->to($entity->getEmail())
                ->subject('Invitation to Wonder')
                ->htmlTemplate('emails/invitation.html.twig')
                ->context(['uuid' => $entity->getUuid(), 'mail' => $entity->getEmail()]);
            try {
                $this->mailer->send($email);
            } catch (TransportExceptionInterface $e) {
                dump($e->getMessage());
            }
        }

        return;
    }
}
