<?php

namespace App\Entity;

use App\Repository\ParrainAppreciationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParrainAppreciationRepository::class)]
class ParrainAppreciation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $appreciation = null;

    #[ORM\Column]
    private ?int $humeur = null;

    #[ORM\Column]
    private ?int $travail = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\ManyToOne(inversedBy: 'parrainAppreciations')]
    private ?Filleul $filleul = null;

    #[ORM\ManyToOne(inversedBy: 'parrainAppreciations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Parrain $parrain = null;

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

    public function getHumeur(): ?int
    {
        return $this->humeur;
    }

    public function setHumeur(int $humeur): static
    {
        $this->humeur = $humeur;

        return $this;
    }

    public function getTravail(): ?int
    {
        return $this->travail;
    }

    public function setTravail(int $travail): static
    {
        $this->travail = $travail;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): static
    {
        $this->dateCreation = $dateCreation;

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

    public function getParrain(): ?Parrain
    {
        return $this->parrain;
    }

    public function setParrain(?Parrain $parrain): static
    {
        $this->parrain = $parrain;

        return $this;
    }
}
