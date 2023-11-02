<?php

namespace App\Entity;

use App\Repository\PictureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PictureRepository::class)]
class Picture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\ManyToOne(inversedBy: 'pictures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Media $Medias = null;

    #[ORM\OneToMany(mappedBy: 'pictureCollector', targetEntity: UserPicture::class)]
    /**
     * @var Collection<\App\Entity\UserPicture
     */
    private Collection $userPictures;

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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

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
}
