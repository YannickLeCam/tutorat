<?php

namespace App\Entity;

use App\Repository\MineureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MineureRepository::class)]
class Mineure
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
    #[ORM\OneToMany(targetEntity: Filleul::class, mappedBy: 'mineure')]
    private Collection $filleuls;

    public function __construct()
    {
        $this->filleuls = new ArrayCollection();
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
            $filleul->setMineure($this);
        }

        return $this;
    }

    public function removeFilleul(Filleul $filleul): static
    {
        if ($this->filleuls->removeElement($filleul)) {
            // set the owning side to null (unless already changed)
            if ($filleul->getMineure() === $this) {
                $filleul->setMineure(null);
            }
        }

        return $this;
    }
}
