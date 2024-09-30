<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private ?string $title = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $status = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $dueDate = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    public function getId() {
        return $this->id;
    }

    public function setId(int $id) {
        $this->id = $id;
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle(string $title) {
        $this->title = $title;
        return $this->title;
    }
    
    public function getDescription() {
        return $this->description;
    }

    public function setDescription(string $description) {
        $this->description = $description;
        return $this->description;
    }
    
    public function getStatus() {
        return $this->status;
    }

    public function setStatus(string $status) {
        $this->status = $status;
        return $this->status;
    }
    
    public function getDueDate() {
        return $this->dueDate;
    }

    public function setDueDate(\DateTimeInterface $dueDate) {
        $this->dueDate = $dueDate;
        return $this->dueDate;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
