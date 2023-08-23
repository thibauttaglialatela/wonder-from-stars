<?php

namespace App\Tests;

use App\DataFixtures\AppFixtures;
use App\Entity\Picture;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AppFixturesTest extends KernelTestCase
{
    protected AbstractDatabaseTool $databaseTool;
    protected EntityManagerInterface $entityManager;

    public function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $this->entityManager = static::$kernel->getContainer()->get('doctrine')->getManager();
        $this->databaseTool = static::$kernel->getContainer()->get(DatabaseToolCollection::class)->get();
    }

    public function testDeletePicture(): void
    {
        $this->databaseTool->loadFixtures([
            AppFixtures::class
        ]);

        $insertedPicture = $this->entityManager->getRepository(Picture::class)->findOneBy([
            'title' => "Pour ce qui s'appelle dévoré de jalousie; -- et, comme Charles regardait le disque du soleil irradiant au loin, dans les bras ouverts et lui envoyait chaque semaine, par le cabinet et débiter toute."
        ]);
        $this->entityManager->getRepository(Picture::class)->remove($insertedPicture, true);
        $deletedPicture = $this->entityManager->getRepository(Picture::class)->findOneBy([
            'title' => "Pour ce qui s'appelle dévoré de jalousie; -- et, comme Charles regardait le disque du soleil irradiant au loin, dans les bras ouverts et lui envoyait chaque semaine, par le cabinet et débiter toute.",
        ]);
        $this->assertNull($deletedPicture,'the picture was deleted');

    }

    public function testPictureExist(): void
    {
        $this->databaseTool->loadFixtures([
            AppFixtures::class
        ]);

        $insertedPicture = $this->entityManager->getRepository(Picture::class)->findOneBy([
            'title' => "Rodolphe jetait les yeux ouverts, comme enlacé dans les pays tropicaux, engendrer des miasmes insalubres; -- cette chaleur, cependant, qui à cause de la plaie vive. Il chantait une petite livre de."
        ]);
        self::assertNotNull($insertedPicture);
    }

}
