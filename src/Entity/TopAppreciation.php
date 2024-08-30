<?php

namespace App\Entity;

use App\Repository\TopAppreciationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TopAppreciationRepository::class)]
class TopAppreciation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $appreciation = null;

    #[ORM\ManyToOne(inversedBy: 'topAppreciations')]
    private ?Filleul $filleul = null;

    #[ORM\ManyToOne(inversedBy: 'topAppreciations')]
    private ?Top $top = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAppreciation(): ?string
    {
        return $this->appreciation;
    }

    public function setAppreciation(string $appreciation): static
    {
        $this->appreciation = $appreciation;

        return $this;
    }

    public function getFilleul(): ?Filleul
    {
        return $this->filleul;
    }

    public function setFilleul(?Filleul $filleul): static
    {
        $this->filleul = $filleul;

        return $this;
    }

    public function getTop(): ?Top
    {
        return $this->top;
    }

    public function setTop(?Top $top): static
    {
        $this->top = $top;

        return $this;
    }
}
