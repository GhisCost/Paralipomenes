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
}
