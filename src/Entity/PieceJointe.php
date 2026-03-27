<?php

namespace App\Entity;

use App\Repository\PieceJointeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PieceJointeRepository::class)]
class PieceJointe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'pieceJointes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Messages $message = null;

    #[ORM\ManyToOne(inversedBy: 'pieceJointes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Corrections $Correction = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?Messages
    {
        return $this->message;
    }

    public function setMessage(?Messages $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getCorrection(): ?Corrections
    {
        return $this->Correction;
    }

    public function setCorrection(?Corrections $Correction): static
    {
        $this->Correction = $Correction;

        return $this;
    }
}
