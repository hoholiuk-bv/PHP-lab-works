<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity]
#[ORM\Table(name: "users")]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 180, unique: true)]
    private string $email;

    #[ORM\Column(type: "json")]
    private array $roles = [];

    #[ORM\Column(type: "string")]
    private string $password;

    #[ORM\Column(type: "datetime", options: ["default" => "CURRENT_TIMESTAMP"])]
    private \DateTime $createdAt;

    #[ORM\Column(type: "datetime", options: ["default" => "CURRENT_TIMESTAMP", "onUpdate" => "CURRENT_TIMESTAMP"])]
    private \DateTime $updatedAt;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }
    public function eraseCredentials(): void
    {
    }
}

//use App\Repository\UserRepository;
//use Doctrine\ORM\Mapping as ORM;
//use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
//use Symfony\Component\Security\Core\User\UserInterface;
//
//#[ORM\Entity(repositoryClass: UserRepository::class)]
//#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_Y', fields: ['y'])]
//class User implements UserInterface, PasswordAuthenticatedUserInterface
//{
//    #[ORM\Id]
//    #[ORM\GeneratedValue]
//    #[ORM\Column]
//    private ?int $id = null;
//
//    #[ORM\Column(length: 180)]
//    private ?string $email  = null;
//
//    #[ORM\Column(type: 'json')]
//    private array $roles = [];
//
//    #[ORM\Column]
//    private ?string $password = null;
//
//    public function getId(): ?int
//    {
//        return $this->id;
//    }
//
//    public function getemail(): ?string
//    {
//        return $this->email;
//    }
//
//    public function setemail(string $email): static
//    {
//        $this->email = $email;
//
//        return $this;
//    }
//
//    public function getUserIdentifier(): string
//    {
//        return (string) $this->email;
//    }
//
//    public function getRoles(): array
//    {
//        return $this->roles;
//    }
//
//    public function setRoles(array $roles): self
//    {
//        $this->roles = $roles;
//        return $this;
//    }
//
//    public function getPassword(): ?string
//    {
//        return $this->password;
//    }
//
//    public function setPassword(string $password): static
//    {
//        $this->password = $password;
//        return $this;
//    }
//
//    public function eraseCredentials(): void
//    {
//    }
//}