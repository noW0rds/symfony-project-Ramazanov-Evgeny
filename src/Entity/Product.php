<?php

namespace App\Entity;

use App\Helper\Interface\AuthorInterface;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product implements AuthorInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\ManyToMany(targetEntity: Guest::class, mappedBy: 'buyingProduct')]
    private Collection $guests;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: PersonalCheck::class, orphanRemoval: true)]
    private Collection $personalChecks;

    #[ORM\ManyToOne(inversedBy: 'productsWhoAuthor')]
    private ?User $whoAuthor = null;

    public function __construct()
    {
        $this->guests = new ArrayCollection();
        $this->personalChecks = new ArrayCollection();
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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, Guest>
     */
    public function getGuests(): Collection
    {
        return $this->guests;
    }

    public function addGuest(Guest $guest): self
    {
        if (!$this->guests->contains($guest)) {
            $this->guests->add($guest);
            $guest->addBuyingProduct($this);
        }

        return $this;
    }

    public function removeGuest(Guest $guest): self
    {
        if ($this->guests->removeElement($guest)) {
            $guest->removeBuyingProduct($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
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
            $personalCheck->setProduct($this);
        }

        return $this;
    }

    public function removePersonalCheck(PersonalCheck $personalCheck): self
    {
        if ($this->personalChecks->removeElement($personalCheck)) {
            // set the owning side to null (unless already changed)
            if ($personalCheck->getProduct() === $this) {
                $personalCheck->setProduct(null);
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
}
