<?php

namespace App\Entity;

use App\Helper\Interface\AuthorInterface;
use App\Repository\GuestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\DocBlock\Tags\Author;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: GuestRepository::class)]
class Guest implements AuthorInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $number = null;

    #[ORM\OneToMany(mappedBy: 'fromGuest', targetEntity: Payment::class)]
    #[Ignore]
    private Collection $incomingPayments;

    #[ORM\OneToMany(mappedBy: 'toGuest', targetEntity: Payment::class)]
    #[Ignore]
    private Collection $outcomingPayments;

    #[ORM\OneToMany(mappedBy: 'buyingGuest', targetEntity: Check::class)]
    private Collection $checks;

    #[ORM\ManyToMany(targetEntity: Product::class, inversedBy: 'guests',  cascade: ['persist'])]
    private Collection $buyingProduct;

    #[ORM\ManyToOne(inversedBy: 'guestsWhoUser')]
    private ?User $whoUser = null;

    #[ORM\OneToMany(mappedBy: 'guest', targetEntity: PersonalCheck::class, orphanRemoval: true)]
    private Collection $personalChecks;

    #[ORM\ManyToOne(inversedBy: 'guestsWhoAuthor')]
    private ?User $whoAuthor = null;

    #[ORM\ManyToMany(targetEntity: Party::class, inversedBy: 'partyGuests')]
    private Collection $parties;

    public function __construct()
    {
        $this->incomingPayments = new ArrayCollection();
        $this->outcomingPayments = new ArrayCollection();
        $this->checks = new ArrayCollection();
        $this->buyingProduct = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->personalChecks = new ArrayCollection();
        $this->parties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number): self
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return Collection<int, Payment>
     */
    public function getIncomingPayments(): Collection
    {
        return $this->incomingPayments;
    }

    public function addIncomingPayment(Payment $incomingPayment): self
    {
        if (!$this->incomingPayments->contains($incomingPayment)) {
            $this->incomingPayments->add($incomingPayment);
            $incomingPayment->setFromGuest($this);
        }

        return $this;
    }

    public function removeIncomingPayment(Payment $incomingPayment): self
    {
        if ($this->incomingPayments->removeElement($incomingPayment)) {
            // set the owning side to null (unless already changed)
            if ($incomingPayment->getFromGuest() === $this) {
                $incomingPayment->setFromGuest(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * @return Collection<int, Payment>
     */
    public function getOutcomingPayments(): Collection
    {
        return $this->outcomingPayments;
    }

    public function addOutcomingPayment(Payment $outcomingPayment): self
    {
        if (!$this->outcomingPayments->contains($outcomingPayment)) {
            $this->outcomingPayments->add($outcomingPayment);
            $outcomingPayment->setToGuest($this);
        }

        return $this;
    }

    public function removeOutcomingPayment(Payment $outcomingPayment): self
    {
        if ($this->outcomingPayments->removeElement($outcomingPayment)) {
            // set the owning side to null (unless already changed)
            if ($outcomingPayment->getToGuest() === $this) {
                $outcomingPayment->setToGuest(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Check>
     */
    public function getChecks(): Collection
    {
        return $this->checks;
    }

    public function addCheck(Check $check): self
    {
        if (!$this->checks->contains($check)) {
            $this->checks->add($check);
            $check->setBuyingGuest($this);
        }

        return $this;
    }

    public function removeCheck(Check $check): self
    {
        if ($this->checks->removeElement($check)) {
            // set the owning side to null (unless already changed)
            if ($check->getBuyingGuest() === $this) {
                $check->setBuyingGuest(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getBuyingProduct(): Collection
    {
        return $this->buyingProduct;
    }

    public function addBuyingProduct(Product $buyingProduct): self
    {
        if (!$this->buyingProduct->contains($buyingProduct)) {
            $this->buyingProduct->add($buyingProduct);
        }

        return $this;
    }

    public function removeBuyingProduct(Product $buyingProduct): self
    {
        $this->buyingProduct->removeElement($buyingProduct);

        return $this;
    }

    public function getWhoUser(): ?User
    {
        return $this->whoUser;
    }

    public function setWhoUser(?User $whoUser): self
    {
        $this->whoUser = $whoUser;

        return $this;
    }

    /**
     * @return Collection<int, PersonalCheck>
     */
    public function getPersonalChecks(): Collection
    {
        return $this->personalChecks;
    }

    public function addPersonalCheck(PersonalCheck $personalCheck): self
    {
        if (!$this->personalChecks->contains($personalCheck)) {
            $this->personalChecks->add($personalCheck);
            $personalCheck->setGuest($this);
        }

        return $this;
    }

    public function removePersonalCheck(PersonalCheck $personalCheck): self
    {
        if ($this->personalChecks->removeElement($personalCheck)) {
            // set the owning side to null (unless already changed)
            if ($personalCheck->getGuest() === $this) {
                $personalCheck->setGuest(null);
            }
        }

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

    /**
     * @return Collection<int, Party>
     */
    public function getParties(): Collection
    {
        return $this->parties;
    }

    public function addParty(Party $party): self
    {
        if (!$this->parties->contains($party)) {
            $this->parties->add($party);
        }

        return $this;
    }

    public function removeParty(Party $party): self
    {
        $this->parties->removeElement($party);

        return $this;
    }
}
