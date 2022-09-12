<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'whoUser', targetEntity: Guest::class)]
    private Collection $guestsWhoUser;

    #[ORM\OneToMany(mappedBy: 'whoAuthor', targetEntity: Check::class)]
    private Collection $checksWhoAuthor;

    #[ORM\OneToMany(mappedBy: 'whoAuthor', targetEntity: Guest::class)]
    private Collection $guestsWhoAuthor;

    #[ORM\OneToMany(mappedBy: 'whoAuthor', targetEntity: Party::class)]
    private Collection $partiesWhoAuthor;

    #[ORM\OneToMany(mappedBy: 'whoAuthor', targetEntity: Payment::class)]
    private Collection $paymentsWhoAuthor;

    #[ORM\OneToMany(mappedBy: 'whoAuthor', targetEntity: PersonalCheck::class)]
    private Collection $personalChecksWhoAuthor;

    #[ORM\OneToMany(mappedBy: 'whoAuthor', targetEntity: Product::class)]
    private Collection $productsWhoAuthor;

    public function __construct()
    {
        $this->guestsWhoUser = new ArrayCollection();
        $this->checksWhoAuthor = new ArrayCollection();
        $this->guestsWhoAuthor = new ArrayCollection();
        $this->partiesWhoAuthor = new ArrayCollection();
        $this->paymentsWhoAuthor = new ArrayCollection();
        $this->personalChecksWhoAuthor = new ArrayCollection();
        $this->productsWhoAuthor = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
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
        // $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
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

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Guest>
     */
    public function getGuestsWhoUser(): Collection
    {
        return $this->guestsWhoUser;
    }

    public function addGuestsWhoUser(Guest $guestsWhoUser): self
    {
        if (!$this->guestsWhoUser->contains($guestsWhoUser)) {
            $this->guestsWhoUser->add($guestsWhoUser);
            $guestsWhoUser->setWhoUser($this);
        }

        return $this;
    }

    public function removeGuestsWhoUser(Guest $guestsWhoUser): self
    {
        if ($this->guestsWhoUser->removeElement($guestsWhoUser)) {
            // set the owning side to null (unless already changed)
            if ($guestsWhoUser->getWhoUser() === $this) {
                $guestsWhoUser->setWhoUser(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getEmail();
    }

    /**
     * @return Collection<int, Check>
     */
    public function getChecksWhoAuthor(): Collection
    {
        return $this->checksWhoAuthor;
    }

    public function addChecksWhoAuthor(Check $checksWhoAuthor): self
    {
        if (!$this->checksWhoAuthor->contains($checksWhoAuthor)) {
            $this->checksWhoAuthor->add($checksWhoAuthor);
            $checksWhoAuthor->setWhoAuthor($this);
        }

        return $this;
    }

    public function removeChecksWhoAuthor(Check $checksWhoAuthor): self
    {
        if ($this->checksWhoAuthor->removeElement($checksWhoAuthor)) {
            // set the owning side to null (unless already changed)
            if ($checksWhoAuthor->getWhoAuthor() === $this) {
                $checksWhoAuthor->setWhoAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Guest>
     */
    public function getGuestsWhoAuthor(): Collection
    {
        return $this->guestsWhoAuthor;
    }

    public function addGuestsWhoAuthor(Guest $guestsWhoAuthor): self
    {
        if (!$this->guestsWhoAuthor->contains($guestsWhoAuthor)) {
            $this->guestsWhoAuthor->add($guestsWhoAuthor);
            $guestsWhoAuthor->setWhoAuthor($this);
        }

        return $this;
    }

    public function removeGuestsWhoAuthor(Guest $guestsWhoAuthor): self
    {
        if ($this->guestsWhoAuthor->removeElement($guestsWhoAuthor)) {
            // set the owning side to null (unless already changed)
            if ($guestsWhoAuthor->getWhoAuthor() === $this) {
                $guestsWhoAuthor->setWhoAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Party>
     */
    public function getPartiesWhoAuthor(): Collection
    {
        return $this->partiesWhoAuthor;
    }

    public function addPartiesWhoAuthor(Party $partiesWhoAuthor): self
    {
        if (!$this->partiesWhoAuthor->contains($partiesWhoAuthor)) {
            $this->partiesWhoAuthor->add($partiesWhoAuthor);
            $partiesWhoAuthor->setWhoAuthor($this);
        }

        return $this;
    }

    public function removePartiesWhoAuthor(Party $partiesWhoAuthor): self
    {
        if ($this->partiesWhoAuthor->removeElement($partiesWhoAuthor)) {
            // set the owning side to null (unless already changed)
            if ($partiesWhoAuthor->getWhoAuthor() === $this) {
                $partiesWhoAuthor->setWhoAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Payment>
     */
    public function getPaymentsWhoAuthor(): Collection
    {
        return $this->paymentsWhoAuthor;
    }

    public function addPaymentsWhoAuthor(Payment $paymentsWhoAuthor): self
    {
        if (!$this->paymentsWhoAuthor->contains($paymentsWhoAuthor)) {
            $this->paymentsWhoAuthor->add($paymentsWhoAuthor);
            $paymentsWhoAuthor->setWhoAuthor($this);
        }

        return $this;
    }

    public function removePaymentsWhoAuthor(Payment $paymentsWhoAuthor): self
    {
        if ($this->paymentsWhoAuthor->removeElement($paymentsWhoAuthor)) {
            // set the owning side to null (unless already changed)
            if ($paymentsWhoAuthor->getWhoAuthor() === $this) {
                $paymentsWhoAuthor->setWhoAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PersonalCheck>
     */
    public function getPersonalChecksWhoAuthor(): Collection
    {
        return $this->personalChecksWhoAuthor;
    }

    public function addPersonalChecksWhoAuthor(PersonalCheck $personalChecksWhoAuthor): self
    {
        if (!$this->personalChecksWhoAuthor->contains($personalChecksWhoAuthor)) {
            $this->personalChecksWhoAuthor->add($personalChecksWhoAuthor);
            $personalChecksWhoAuthor->setWhoAuthor($this);
        }

        return $this;
    }

    public function removePersonalChecksWhoAuthor(PersonalCheck $personalChecksWhoAuthor): self
    {
        if ($this->personalChecksWhoAuthor->removeElement($personalChecksWhoAuthor)) {
            // set the owning side to null (unless already changed)
            if ($personalChecksWhoAuthor->getWhoAuthor() === $this) {
                $personalChecksWhoAuthor->setWhoAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProductsWhoAuthor(): Collection
    {
        return $this->productsWhoAuthor;
    }

    public function addProductsWhoAuthor(Product $productsWhoAuthor): self
    {
        if (!$this->productsWhoAuthor->contains($productsWhoAuthor)) {
            $this->productsWhoAuthor->add($productsWhoAuthor);
            $productsWhoAuthor->setWhoAuthor($this);
        }

        return $this;
    }

    public function removeProductsWhoAuthor(Product $productsWhoAuthor): self
    {
        if ($this->productsWhoAuthor->removeElement($productsWhoAuthor)) {
            // set the owning side to null (unless already changed)
            if ($productsWhoAuthor->getWhoAuthor() === $this) {
                $productsWhoAuthor->setWhoAuthor(null);
            }
        }

        return $this;
    }
}