<?php

namespace App\Entity;

use App\Repository\UserPictureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserPictureRepository::class)]
class UserPicture
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $comment = null;

    #[ORM\Column(nullable: true)]
    private ?int $rating = null;

    #[ORM\ManyToOne(inversedBy: 'userPictures')]
    private ?Picture $pictureCollector = null;

    #[ORM\ManyToOne(inversedBy: 'userPictures')]
    private ?User $collector = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function getPictureCollector(): ?Picture
    {
        return $this->pictureCollector;
    }

    public function setPictureCollector(?Picture $pictureCollector): static
    {
        $this->pictureCollector = $pictureCollector;

        return $this;
    }

    public function getCollector(): ?User
    {
        return $this->collector;
    }

    public function setCollector(?User $collector): static
    {
        $this->collector = $collector;

        return $this;
    }
}
