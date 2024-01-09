<?php

namespace App\DataFixtures;

use App\Entity\Media;
use App\Entity\Picture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AppFixtures extends Fixture
{
    public const MEDIAS = ['image', 'video'];

    public function load(ObjectManager $manager): void
    {
        foreach (self::MEDIAS as $value) {
            $media = new Media();
            $media->setName($value);
            $manager->persist($media);
        }

        $manager->flush();
    }
}
