<?php

namespace App\Entity;

use App\Repository\ParrainRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParrainRepository::class)]
class Parrain
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
     * @var Collection<int, Filleul>
     */
    #[ORM\OneToMany(targetEntity: Filleul::class, mappedBy: 'parrain')]
    private Collection $filleuls;

    /**
     * @var Collection<int, ParrainAppreciation>
     */
    #[ORM\OneToMany(targetEntity: ParrainAppreciation::class, mappedBy: 'parrain')]
    private Collection $parrainAppreciations;

    public function __construct()
    {
        $this->filleuls = new ArrayCollection();
        $this->parrainAppreciations = new ArrayCollection();
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
     * @return Collection<int, Filleul>
     */
    public function getFilleuls(): Collection
    {
        return $this->filleuls;
    }

    public function addFilleul(Filleul $filleul): static
    {
        if (!$this->filleuls->contains($filleul)) {
            $this->filleuls->add($filleul);
            $filleul->setParrain($this);
        }

        return $this;
    }

    public function removeFilleul(Filleul $filleul): static
    {
        if ($this->filleuls->removeElement($filleul)) {
            // set the owning side to null (unless already changed)
            if ($filleul->getParrain() === $this) {
                $filleul->setParrain(null);
            }
        }

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
            $parrainAppreciation->setParrain($this);
        }

        return $this;
    }

    public function removeParrainAppreciation(ParrainAppreciation $parrainAppreciation): static
    {
        if ($this->parrainAppreciations->removeElement($parrainAppreciation)) {
            // set the owning side to null (unless already changed)
            if ($parrainAppreciation->getParrain() === $this) {
                $parrainAppreciation->setParrain(null);
            }
        }

        return $this;
    }
}
