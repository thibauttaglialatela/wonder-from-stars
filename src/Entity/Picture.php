<?php

namespace App\Entity;

use App\Repository\PictureRepository;
use App\Service\PictureUploader;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PictureRepository::class)]
class Picture
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Your title must have at least {{ limit }} characters',
        maxMessage: 'The title cannot be longer than {{ limit }}!'
    )]
    private ?string $title = null;


    #[ORM\ManyToOne(inversedBy: 'pictures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Media $Medias = null;

    #[ORM\OneToMany(mappedBy: 'pictureCollector', targetEntity: UserPicture::class, cascade: ['remove'])]
    /**
     * @var Collection<\App\Entity\UserPicture
     */
    private Collection $userPictures;

    #[ORM\Column]
    private ?bool $isValidated = false;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private ?string $alt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pictureFilename = null;

    public function __construct()
    {
        $this->userPictures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }



    public function getMedias(): ?Media
    {
        return $this->Medias;
    }

    public function setMedias(?Media $Medias): static
    {
        $this->Medias = $Medias;

        return $this;
    }

    /**
     * @return Collection<int, UserPicture>
     */
    public function getUserPictures(): Collection
    {
        return $this->userPictures;
    }

    public function addUserPicture(UserPicture $userPicture): static
    {
        if (!$this->userPictures->contains($userPicture)) {
            $this->userPictures->add($userPicture);
            $userPicture->setPictureCollector($this);
        }

        return $this;
    }

    public function removeUserPicture(UserPicture $userPicture): static
    {
        if ($this->userPictures->removeElement($userPicture)) {
            // set the owning side to null (unless already changed)
            if ($userPicture->getPictureCollector() === $this) {
                $userPicture->setPictureCollector(null);
            }
        }

        return $this;
    }

    public function isIsValidated(): ?bool
    {
        return $this->isValidated;
    }

    public function setIsValidated(bool $isValidated): static
    {
        $this->isValidated = $isValidated;

        return $this;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(string $alt): static
    {
        $this->alt = $alt;

        return $this;
    }

    public function setPictureFile(UploadedFile $file, PictureUploader $uploader, string $uploadDir = null): self
    {
        $this->pictureFilename = $uploader->addPicture($file, $uploadDir);
        return $this;
    }

    public function getPictureFilename(): ?string
    {
        return $this->pictureFilename;
    }

    public function setPictureFilename(string $pictureFilename): static
    {
        $this->pictureFilename = $pictureFilename;

        return $this;
    }

}
