<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    private ?string $email = null;

    #[ORM\Column(type: 'simple_array')]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotCompromisedPassword]
    #[Assert\Length(
        min: 8,
        max: 4096,
        minMessage: 'Your password must be at least {{ limit }} characters long',
        maxMessage: 'Your password cannot be longer than {{ limit }} characters',
    )]
    #[Assert\Regex(
        pattern: '/^.*(?=.{8,})(?=.*[a-zA-Z])(?=.*\d)(?=.*[!#$%&? "]).*$/',
        message: 'Your password must contain letters, numbers, special characters, and be at least 8 characters long.'
    )]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Pseudo = null;

    #[ORM\OneToMany(mappedBy: 'collector', targetEntity: UserPicture::class)]
    /**
     * @var Collection<int, UserPicture>
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @return $this
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPseudo(): ?string
    {
        return $this->Pseudo;
    }

    public function setPseudo(?string $Pseudo): static
    {
        $this->Pseudo = $Pseudo;

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
            $userPicture->setCollector($this);
        }

        return $this;
    }

    public function removeUserPicture(UserPicture $userPicture): static
    {
        if ($this->userPictures->removeElement($userPicture)) {
            // set the owning side to null (unless already changed)
            if ($userPicture->getCollector() === $this) {
                $userPicture->setCollector(null);
            }
        }

        return $this;
    }
}
