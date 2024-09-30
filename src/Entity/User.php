<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity()]
#[ORM\Table(name: "users")]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', unique: true)]
    private string $email;

    #[ORM\Column(type: 'string')]
    private string $password;

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }


    public function getUserIdentifier(): string
    {
        return (string) $this->id;
    }
    
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): string
    {
        $this->password = $password;
        return $this->password;
    }

    public function setEmail(string $email): string
    {
        $this->email = $email;

        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function eraseCredentials():void 
    {

    }
}
