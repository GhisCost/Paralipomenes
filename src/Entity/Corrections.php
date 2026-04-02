<?php

namespace App\Entity;

use App\Enum\StatutCorrection;
use App\Repository\CorrectionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CorrectionsRepository::class)]
class Corrections implements \ArrayAccess
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: StatutCorrection::class)]
    private ?StatutCorrection $statut = null;

    #[ORM\ManyToOne(inversedBy: 'corrections')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToOne(inversedBy: 'corrections', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Chapitres $Chapitres = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Contenu = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Histoires $Histoire = null;

    /**
     * @var Collection<int, PieceJointe>
     */
    #[ORM\OneToMany(targetEntity: PieceJointe::class, mappedBy: 'Correction')]
    private Collection $pieceJointes;

    #[ORM\Column]
    private ?int $numeroChapitre = 0;

    public function __construct()
    {
        $this->pieceJointes = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatut(): ?StatutCorrection
    {
        return $this->statut;
    }

    public function setStatut(StatutCorrection $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getChapitres(): ?Chapitres
    {
        return $this->Chapitres;
    }

    public function setChapitres(Chapitres $Chapitres): static
    {
        $this->Chapitres = $Chapitres;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->Contenu;
    }

    public function setContenu(?string $Contenu): static
    {
        $this->Contenu = $Contenu;

        return $this;
    }

    public function getHistoire(): ?Histoires
    {
        return $this->Histoire;
    }

    public function setHistoire(?Histoires $Histoire): static
    {
        $this->Histoire = $Histoire;

        return $this;
    }

    function offsetExists(mixed $offset): bool
    {
        return $offset ? true : false;
    }
    function offsetGet(mixed $offset): mixed
    {
         if (property_exists($this, $offset)) {
        return $this->$offset;
    }
    return null;
    }
    function offsetSet(mixed $offset, mixed $value): void
    {
    }
    function offsetUnset(mixed $offset): void
    {
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
            $pieceJointe->setCorrection($this);
        }

        return $this;
    }

    public function removePieceJointe(PieceJointe $pieceJointe): static
    {
        if ($this->pieceJointes->removeElement($pieceJointe)) {
            // set the owning side to null (unless already changed)
            if ($pieceJointe->getCorrection() === $this) {
                $pieceJointe->setCorrection(null);
            }
        }

        return $this;
    }

    public function getNumeroChapitre(): ?int
    {
        return $this->numeroChapitre;
    }

    public function setNumeroChapitre(int $numeroChapitre): static
    {
        $this->numeroChapitre = $numeroChapitre;

        return $this;
    }
}
