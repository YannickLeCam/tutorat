<?php

namespace App\Entity;

use App\Repository\FaculteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FaculteRepository::class)]
class Faculte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Filleul>
     */
    #[ORM\OneToMany(targetEntity: Filleul::class, mappedBy: 'faculte')]
    private Collection $filleuls;

    /**
     * @var Collection<int, Parrain>
     */
    #[ORM\OneToMany(targetEntity: Parrain::class, mappedBy: 'faculte')]
    private Collection $parrains;

    /**
     * @var Collection<int, Top>
     */
    #[ORM\OneToMany(targetEntity: Top::class, mappedBy: 'faculte')]
    private Collection $tops;

    public function __construct()
    {
        $this->filleuls = new ArrayCollection();
        $this->parrains = new ArrayCollection();
        $this->tops = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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
            $filleul->setFaculte($this);
        }

        return $this;
    }

    public function removeFilleul(Filleul $filleul): static
    {
        if ($this->filleuls->removeElement($filleul)) {
            // set the owning side to null (unless already changed)
            if ($filleul->getFaculte() === $this) {
                $filleul->setFaculte(null);
            }
        }

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
            $parrain->setFaculte($this);
        }

        return $this;
    }

    public function removeParrain(Parrain $parrain): static
    {
        if ($this->parrains->removeElement($parrain)) {
            // set the owning side to null (unless already changed)
            if ($parrain->getFaculte() === $this) {
                $parrain->setFaculte(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Top>
     */
    public function getTops(): Collection
    {
        return $this->tops;
    }

    public function addTop(Top $top): static
    {
        if (!$this->tops->contains($top)) {
            $this->tops->add($top);
            $top->setFaculte($this);
        }

        return $this;
    }

    public function removeTop(Top $top): static
    {
        if ($this->tops->removeElement($top)) {
            // set the owning side to null (unless already changed)
            if ($top->getFaculte() === $this) {
                $top->setFaculte(null);
            }
        }

        return $this;
    }
}
