<?php

namespace App\Entity;

use App\Repository\MessagesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessagesRepository::class)]
class Messages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contenu = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $dateEnvoi = null;

   
    #[ORM\ManyToOne(inversedBy: 'messagesReçus')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $destinataire = null;

    #[ORM\ManyToOne(inversedBy: 'messageEnvoyer')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $expediteur = null;

    /**
     * @var Collection<int, PieceJointe>
     */
    #[ORM\OneToMany(targetEntity: PieceJointe::class, mappedBy: 'message')]
    private Collection $pieceJointes;

    #[ORM\Column]
    private ?bool $envoyer = false;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $objet = null;

    public function __construct()
    {
        $this->pieceJointes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getDateEnvoi(): ?\DateTime
    {
        return $this->dateEnvoi;
    }

    public function setDateEnvoi(\DateTime $dateEnvoi): static
    {
        $this->dateEnvoi = $dateEnvoi;

        return $this;
    }


    public function getDestinataire(): ?User
    {
        return $this->destinataire;
    }

    public function setDestinataire(?User $destinataire): static
    {
        $this->destinataire = $destinataire;

        return $this;
    }

    public function getExpediteur(): ?User
    {
        return $this->expediteur;
    }

    public function setExpediteur(?User $expediteur): static
    {
        $this->expediteur = $expediteur;

        return $this;
    }

    /**
     * @return Collection<int, PieceJointe>
     */
    public function getPieceJointes(): Collection
    {
        return $this->pieceJointes;
    }

    public function addPieceJointe(PieceJointe $pieceJointe): static
    {
        if (!$this->pieceJointes->contains($pieceJointe)) {
            $this->pieceJointes->add($pieceJointe);
            $pieceJointe->setMessage($this);
        }

        return $this;
    }

    public function removePieceJointe(PieceJointe $pieceJointe): static
    {
        if ($this->pieceJointes->removeElement($pieceJointe)) {
            // set the owning side to null (unless already changed)
            if ($pieceJointe->getMessage() === $this) {
                $pieceJointe->setMessage(null);
            }
        }

        return $this;
    }

    public function isEnvoyer(): ?bool
    {
        return $this->envoyer;
    }

    public function setEnvoyer(bool $envoyer): static
    {
        $this->envoyer = $envoyer;

        return $this;
    }

    public function getObjet(): ?string
    {
        return $this->objet;
    }

    public function setObjet(?string $objet): static
    {
        $this->objet = $objet;

        return $this;
    }
}
