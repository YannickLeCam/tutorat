<?php

namespace App\Entity;

use App\Repository\FilleulRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FilleulRepository::class)]
class Filleul
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\ManyToOne(inversedBy: 'filleuls')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Mineure $mineure = null;

    #[ORM\ManyToOne(inversedBy: 'filleuls')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Specialite $specialite = null;

    #[ORM\ManyToOne(inversedBy: 'filleuls')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Parrain $parrain = null;

    /**
     * @var Collection<int, ParrainAppreciation>
     */
    #[ORM\OneToMany(targetEntity: ParrainAppreciation::class, mappedBy: 'filleul')]
    private Collection $parrainAppreciations;

    #[ORM\ManyToOne(inversedBy: 'filleuls')]
    private ?Faculte $faculte = null;

    /**
     * @var Collection<int, TopAppreciation>
     */
    #[ORM\OneToMany(targetEntity: TopAppreciation::class, mappedBy: 'filleul')]
    private Collection $topAppreciations;

    /**
     * @var Collection<int, NoteEtudiant>
     */
    #[ORM\OneToMany(targetEntity: NoteEtudiant::class, mappedBy: 'filleul')]
    private Collection $noteEtudiants;

    public function __construct()
    {
        $this->parrainAppreciations = new ArrayCollection();
        $this->topAppreciations = new ArrayCollection();
        $this->noteEtudiants = new ArrayCollection();
    }

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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getMineure(): ?Mineure
    {
        return $this->mineure;
    }

    public function setMineure(?Mineure $mineure): static
    {
        $this->mineure = $mineure;

        return $this;
    }

    public function getSpecialite(): ?Specialite
    {
        return $this->specialite;
    }

    public function setSpecialite(?Specialite $specialite): static
    {
        $this->specialite = $specialite;

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

    /**
     * @return Collection<int, ParrainAppreciation>
     */
    public function getParrainAppreciations(): Collection
    {
        return $this->parrainAppreciations;
    }

    public function addParrainAppreciation(ParrainAppreciation $parrainAppreciation): static
    {
        if (!$this->parrainAppreciations->contains($parrainAppreciation)) {
            $this->parrainAppreciations->add($parrainAppreciation);
            $parrainAppreciation->setFilleul($this);
        }

        return $this;
    }

    public function removeParrainAppreciation(ParrainAppreciation $parrainAppreciation): static
    {
        if ($this->parrainAppreciations->removeElement($parrainAppreciation)) {
            // set the owning side to null (unless already changed)
            if ($parrainAppreciation->getFilleul() === $this) {
                $parrainAppreciation->setFilleul(null);
            }
        }

        return $this;
    }

    public function getFaculte(): ?Faculte
    {
        return $this->faculte;
    }

    public function setFaculte(?Faculte $faculte): static
    {
        $this->faculte = $faculte;

        return $this;
    }

    /**
     * @return Collection<int, TopAppreciation>
     */
    public function getTopAppreciations(): Collection
    {
        return $this->topAppreciations;
    }

    public function addTopAppreciation(TopAppreciation $topAppreciation): static
    {
        if (!$this->topAppreciations->contains($topAppreciation)) {
            $this->topAppreciations->add($topAppreciation);
            $topAppreciation->setFilleul($this);
        }

        return $this;
    }

    public function removeTopAppreciation(TopAppreciation $topAppreciation): static
    {
        if ($this->topAppreciations->removeElement($topAppreciation)) {
            // set the owning side to null (unless already changed)
            if ($topAppreciation->getFilleul() === $this) {
                $topAppreciation->setFilleul(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, NoteEtudiant>
     */
    public function getNoteEtudiants(): Collection
    {
        return $this->noteEtudiants;
    }

    public function addNoteEtudiant(NoteEtudiant $noteEtudiant): static
    {
        if (!$this->noteEtudiants->contains($noteEtudiant)) {
            $this->noteEtudiants->add($noteEtudiant);
            $noteEtudiant->setFilleul($this);
        }

        return $this;
    }

    public function removeNoteEtudiant(NoteEtudiant $noteEtudiant): static
    {
        if ($this->noteEtudiants->removeElement($noteEtudiant)) {
            // set the owning side to null (unless already changed)
            if ($noteEtudiant->getFilleul() === $this) {
                $noteEtudiant->setFilleul(null);
            }
        }

        return $this;
    }
}
