<?php

namespace App\Entity;

use App\Repository\NoteEtudiantRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NoteEtudiantRepository::class)]
class NoteEtudiant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(nullable: true)]
    private ?float $note = null;

    #[ORM\Column]
    private ?float $total_points = null;

    #[ORM\Column(nullable: true)]
    private ?int $rang = null;

    #[ORM\ManyToOne(inversedBy: 'noteEtudiants')]
    private ?Filleul $filleul = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(?float $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getTotalPoints(): ?float
    {
        return $this->total_points;
    }

    public function setTotalPoints(?float $total_points): static
    {
        $this->total_points = $total_points;

        return $this;
    }

    public function getRang(): ?int
    {
        return $this->rang;
    }

    public function setRang(?int $rang): static
    {
        $this->rang = $rang;

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
}
