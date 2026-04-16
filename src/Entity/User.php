<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 40, nullable: true)]
    private ?string $username = null;

    #[ORM\Column]
    private bool $isVerified = false;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Histoires $histoires = null;

    /**
     * @var Collection<int, Corrections>
     */
    #[ORM\OneToMany(targetEntity: Corrections::class, mappedBy: 'user')]
    private Collection $corrections;

    /**
     * @var Collection<int, Messages>
     */
    #[ORM\OneToMany(targetEntity: Messages::class, mappedBy: 'destinataire')]
    private Collection $messagesReçus;

    /**
     * @var Collection<int, Messages>
     */
    #[ORM\OneToMany(targetEntity: Messages::class, mappedBy: 'expediteur')]
    private Collection $messageEnvoyer;

    public function __construct()
    {
        $this->corrections = new ArrayCollection();
        $this->messagesReçus = new ArrayCollection();
        $this->messageEnvoyer = new ArrayCollection();
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

        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Ensure the session doesn't contain actual password hashes by CRC32C-hashing them, as supported since Symfony 7.3.
     */
    public function __serialize(): array
    {
        $data = (array) $this;
        $data["\0" . self::class . "\0password"] = hash('crc32c', $this->password);
        
        return $data;
    }

    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // @deprecated, to be removed when upgrading to Symfony 8
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getHistoires(): ?Histoires
    {
        return $this->histoires;
    }

    public function setHistoires(Histoires $histoires): static
    {
     
        if ($histoires->getUser() !== $this) {
            $histoires->setUser($this);
        }

        $this->histoires = $histoires;

        return $this;
    }

    /**
     * @return Collection<int, Corrections>
     */
    public function getCorrections(): Collection
    {
        return $this->corrections;
    }

    public function addCorrection(Corrections $correction): static
    {
        if (!$this->corrections->contains($correction)) {
            $this->corrections->add($correction);
            $correction->setUser($this);
        }

        return $this;
    }

    public function removeCorrection(Corrections $correction): static
    {
        if ($this->corrections->removeElement($correction)) {
           
            if ($correction->getUser() === $this) {
                $correction->setUser(null);
            }
        }

        return $this;
    }


     public function __tostring(): string {
        return $this->email;
    }

     /**
      * @return Collection<int, Messages>
      */
     public function getMessagesReçus(): Collection
     {
         return $this->messagesReçus;
     }

     public function addMessagesReUs(Messages $messagesReUs): static
     {
         if (!$this->messagesReçus->contains($messagesReUs)) {
             $this->messagesReçus->add($messagesReUs);
             $messagesReUs->setDestinataire($this);
         }

         return $this;
     }

     public function removeMessagesReUs(Messages $messagesReUs): static
     {
         if ($this->messagesReçus->removeElement($messagesReUs)) {
             // set the owning side to null (unless already changed)
             if ($messagesReUs->getDestinataire() === $this) {
                 $messagesReUs->setDestinataire(null);
             }
         }

         return $this;
     }

     /**
      * @return Collection<int, Messages>
      */
     public function getMessageEnvoyer(): Collection
     {
         return $this->messageEnvoyer;
     }

     public function addMessageEnvoyer(Messages $messageEnvoyer): static
     {
         if (!$this->messageEnvoyer->contains($messageEnvoyer)) {
             $this->messageEnvoyer->add($messageEnvoyer);
             $messageEnvoyer->setExpediteur($this);
         }

         return $this;
     }

     public function removeMessageEnvoyer(Messages $messageEnvoyer): static
     {
         if ($this->messageEnvoyer->removeElement($messageEnvoyer)) {
             // set the owning side to null (unless already changed)
             if ($messageEnvoyer->getExpediteur() === $this) {
                 $messageEnvoyer->setExpediteur(null);
             }
         }

         return $this;
     }
}
