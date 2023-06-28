<?php

namespace App\DataFixtures;

use App\Entity\Media;
use App\Entity\Picture;
use App\Entity\User;
use App\Entity\UserPicture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

class AppFixtures extends Fixture
{
    const MEDIAS = ['image', 'video'];
    private UserPasswordHasherInterface $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher) {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $medias = [];
        foreach(self::MEDIAS as $value) {
            $media = new Media();
            $media->setName($value);
            $manager->persist($media);
            $medias[] = $media;
    }

        //création de 10 utilisateurs
        $users = [];
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($faker->email());
            $user->setPseudo($faker->userName());
            $plaintextPassword = $faker->password();
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);
            $manager->persist($user);
            $users[] = $user;
        }

        //création de 10 images
        $pictures = [];
        for ($i = 0; $i < 10; $i++) {
            $picture = new Picture();
            $picture->setTitle($faker->realText());
            $picture->setDescription($faker->paragraph());
            $picture->setUrl('https://picsum.photos/200/300');
            $picture->setDate($faker->dateTime());
            $picture->setMedias($faker->randomElement($medias));
            $manager->persist($picture);
            $pictures[] = $picture;
        }

        //création des UserPictures
        $userPictures = [];
        for ($i = 0; $i < 10; $i++) {
            $userPicture = new UserPicture();
            $userPicture->setPictureCollector($faker->randomElement($pictures));
            $userPicture->setCollector($faker->randomElement($users));
            $userPicture->setRating($faker->numberBetween(0, 5));
            $userPicture->setComment($faker->paragraph());
            $userPicture->setCreatedAt($faker->dateTime());
            $manager->persist($userPicture);
        }


        $manager->flush();
    }
}
