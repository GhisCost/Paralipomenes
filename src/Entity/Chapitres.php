<?php

namespace App\Entity;

use App\Repository\ChapitresRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChapitresRepository::class)]
class Chapitres
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contenu = null;

    #[ORM\ManyToOne(inversedBy: 'chapitres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Histoires $histoires = null;

    #[ORM\OneToOne(mappedBy: 'Chapitres', cascade: ['persist', 'remove'])]
    private ?Corrections $corrections = null;

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

    public function getHistoires(): ?Histoires
    {
        return $this->histoires;
    }

    public function setHistoires(?Histoires $histoires): static
    {
        $this->histoires = $histoires;

        return $this;
    }

    public function getCorrections(): ?Corrections
    {
        return $this->corrections;
    }

    public function setCorrections(Corrections $corrections): static
    {
        // set the owning side of the relation if necessary
        if ($corrections->getChapitres() !== $this) {
            $corrections->setChapitres($this);
        }

        $this->corrections = $corrections;

        return $this;
    }
}
