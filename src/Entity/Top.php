<?php

namespace App\Entity;

use App\Repository\TopRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TopRepository::class)]
class Top
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    /**
     * @var Collection<int, Parrain>
     */
    #[ORM\OneToMany(targetEntity: Parrain::class, mappedBy: 'top')]
    private Collection $parrains;

    #[ORM\ManyToOne(inversedBy: 'tops')]
    private ?Faculte $faculte = null;

    /**
     * @var Collection<int, TopAppreciation>
     */
    #[ORM\OneToMany(targetEntity: TopAppreciation::class, mappedBy: 'top')]
    private Collection $topAppreciations;


    public function __construct()
    {
        $this->parrains = new ArrayCollection();
        $this->topAppreciations = new ArrayCollection();
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

    /**
     * @return Collection<int, Parrain>
     */
    public function getParrains(): Collection
    {
        return $this->parrains;
    }

    public function addParrain(Parrain $parrain): static
    {
        if (!$this->parrains->contains($parrain)) {
            $this->parrains->add($parrain);
            $parrain->setTop($this);
        }

        return $this;
    }

    public function removeParrain(Parrain $parrain): static
    {
        if ($this->parrains->removeElement($parrain)) {
            // set the owning side to null (unless already changed)
            if ($parrain->getTop() === $this) {
                $parrain->setTop(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return "$this->prenom $this->nom";
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
            $topAppreciation->setTop($this);
        }

        return $this;
    }

    public function removeTopAppreciation(TopAppreciation $topAppreciation): static
    {
        if ($this->topAppreciations->removeElement($topAppreciation)) {
            // set the owning side to null (unless already changed)
            if ($topAppreciation->getTop() === $this) {
                $topAppreciation->setTop(null);
            }
        }

        return $this;
    }
}
