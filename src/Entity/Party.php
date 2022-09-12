<?php

namespace App\Entity;

use App\Helper\Interface\AuthorInterface;
use App\Repository\PartyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\PrePersist;

#[ORM\Entity(repositoryClass: PartyRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Party implements AuthorInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $dateAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $location = null;

    #[ORM\ManyToOne(inversedBy: 'partiesWhoAuthor')]
    private ?User $whoAuthor = null;

    #[ORM\ManyToMany(targetEntity: Guest::class, mappedBy: 'parties')]
    private Collection $partyGuests;

    public function __construct()
    {
        $this->partyGuests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDateAt(): ?\DateTimeImmutable
    {
        return $this->dateAt;
    }

    public function setDateAt(?\DateTimeImmutable $dateAt): self
    {
        $this->dateAt = $dateAt;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    #[PrePersist]
    public function doStuffOnPrePersist(LifecycleEventArgs $eventArgs)
    {
        $this->dateAt = new \DateTimeImmutable();
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

    /**
     * @return Collection<int, Guest>
     */
    public function getPartyGuests(): Collection
    {
        return $this->partyGuests;
    }

    public function addPartyGuest(Guest $partyGuest): self
    {
        if (!$this->partyGuests->contains($partyGuest)) {
            $this->partyGuests->add($partyGuest);
            $partyGuest->addParty($this);
        }

        return $this;
    }

    public function removePartyGuest(Guest $partyGuest): self
    {
        if ($this->partyGuests->removeElement($partyGuest)) {
            $partyGuest->removeParty($this);
        }

        return $this;
    }
}
