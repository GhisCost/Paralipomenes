<?php

namespace App\Entity;

use App\Enum\StatutCorrection;
use App\Repository\CorrectionsRepository;
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
    private ?User $User = null;

    #[ORM\OneToOne(inversedBy: 'corrections', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Chapitres $Chapitres = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Contenu = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Histoires $Histoire = null;



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
        return $this->User;
    }

    public function setUser(?User $User): static
    {
        $this->User = $User;

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
        return $offset;
    }
    function offsetSet(mixed $offset, mixed $value): void
    {
    }
    function offsetUnset(mixed $offset): void
    {
    }
}
