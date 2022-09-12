<?php

namespace App\Entity;

use App\Helper\Interface\AuthorInterface;
use App\Repository\PaymentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\PrePersist;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ORM\Entity(repositoryClass: PaymentRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Payment implements AuthorInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    #[NotBlank]
    private ?float $cost = null;

    #[ORM\ManyToOne(inversedBy: 'incomingPayments')]
    private ?Guest $fromGuest = null;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'], inversedBy: 'outcomingPayments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Guest $toGuest = null;

    #[ORM\ManyToOne(inversedBy: 'paymentsWhoAuthor')]
    private ?User $whoAuthor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCost(): ?float
    {
        return $this->cost;
    }

    public function setCost(float $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    public function getFromGuest(): ?Guest
    {
        return $this->fromGuest;
    }

    public function setFromGuest(?Guest $fromGuest): self
    {
        $this->fromGuest = $fromGuest;

        return $this;
    }

    public function getToGuest(): ?Guest
    {
        return $this->toGuest;
    }

    public function setToGuest(?Guest $toGuest): self
    {
        $this->toGuest = $toGuest;

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

    #[PrePersist]
    public function doStuffOnPrePersist(LifecycleEventArgs $eventArgs)
    {
        $this->date = new \DateTimeImmutable();
    }
}
