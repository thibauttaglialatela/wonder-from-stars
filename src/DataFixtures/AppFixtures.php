<?php

namespace App\DataFixtures;

use App\Entity\Media;
use App\Entity\Picture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public const MEDIAS = ['image', 'video'];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $medias = [];
        foreach (self::MEDIAS as $value) {
            $media = new Media();
            $media->setName($value);
            $manager->persist($media);
            $medias[] = $media;
        }

        // création de 10 images
        $pictures = [];
        for ($i = 0; $i < 10; ++$i) {
            $picture = new Picture();
            $picture->setTitle($faker->realText(80));
            $picture->setDescription($faker->paragraph());
            $picture->setUrl('https://picsum.photos/300');
            $picture->setDate($faker->dateTime());
            $picture->setMedias($faker->randomElement($medias));
            $manager->persist($picture);
            $pictures[] = $picture;
        }

        $manager->flush();
    }
}
