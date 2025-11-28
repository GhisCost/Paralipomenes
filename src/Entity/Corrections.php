<?php

namespace App\Entity;

use App\Enum\StatutHistoire;
use App\Repository\CorrectionsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CorrectionsRepository::class)]
class Corrections
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: StatutHistoire::class)]
    private ?StatutHistoire $statut = null;

    #[ORM\ManyToOne(inversedBy: 'corrections')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User = null;

    #[ORM\OneToOne(inversedBy: 'corrections', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Chapitres $Chapitres = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatut(): ?StatutHistoire
    {
        return $this->statut;
    }

    public function setStatut(StatutHistoire $statut): static
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
}
