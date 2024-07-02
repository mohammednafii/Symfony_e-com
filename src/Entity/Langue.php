<?php

namespace App\Entity;

use App\Repository\LangueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LangueRepository::class)]
class Langue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_langue = null;

    /**
     * @var Collection<int, Livre>
     */
    #[ORM\OneToMany(targetEntity: Livre::class, mappedBy: 'Langue')]
    private Collection $livres;

    public function __construct()
    {
        $this->livres = new ArrayCollection();
    }

    #[ORM\ManyToOne(inversedBy: 'id_langue')]
    #[ORM\JoinColumn(nullable: false)]


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }
    public function __toString(): string
    {
        return $this->nom;
    }


    public function getNomLangue(): ?string
    {
        return $this->nom_langue;
    }

    public function setNomLangue(string $nom_langue): static
    {
        $this->nom_langue = $nom_langue;

        return $this;
    }

    /**
     * @return Collection<int, Livre>
     */
    public function getLivres(): Collection
    {
        return $this->livres;
    }

    public function addLivre(Livre $livre): static
    {
        if (!$this->livres->contains($livre)) {
            $this->livres->add($livre);
            $livre->setLangue($this);
        }

        return $this;
    }

    public function removeLivre(Livre $livre): static
    {
        if ($this->livres->removeElement($livre)) {
            // set the owning side to null (unless already changed)
            if ($livre->getLangue() === $this) {
                $livre->setLangue(null);
            }
        }

        return $this;
    }
}
