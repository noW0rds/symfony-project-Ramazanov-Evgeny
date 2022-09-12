<?php

namespace App\Entity;

use App\Helper\Interface\AuthorInterface;
use App\Repository\PersonalCheckRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonalCheckRepository::class)]
class PersonalCheck implements AuthorInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'personalChecks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Check $whoCheck = null;

    #[ORM\ManyToOne(inversedBy: 'personalChecks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\Column]
    private ?int $amount = null;

    #[ORM\ManyToOne(inversedBy: 'personalChecks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Guest $guest = null;

    #[ORM\ManyToOne(inversedBy: 'personalChecksWhoAuthor')]
    private ?User $whoAuthor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWhoCheck(): ?Check
    {
        return $this->whoCheck;
    }

    public function setWhoCheck(?Check $WhoCheck): self
    {
        $this->whoCheck = $WhoCheck;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getGuest(): ?Guest
    {
        return $this->guest;
    }

    public function setGuest(?Guest $guest): self
    {
        $this->guest = $guest;

        return $this;
    }

    public function getWhoAuthor(): ?User
    {
        return $this->whoAuthor;
    }

    public function setWhoAuthor(?User $whoAuthor): self
    {
        $this->whoAuthor = $whoAuthor;

        return $this;
    }
}
