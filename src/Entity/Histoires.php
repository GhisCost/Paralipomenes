<?php

namespace App\Entity;

use App\Enum\StatutHistoire;
use App\Repository\HistoiresRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HistoiresRepository::class)]
class Histoires
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: StatutHistoire::class)]
    private ?StatutHistoire $statut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $datePublication = null;

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

    public function getDatePublication(): ?\DateTime
    {
        return $this->datePublication;
    }

    public function setDatePublication(?\DateTime $datePublication): static
    {
        $this->datePublication = $datePublication;

        return $this;
    }
}
