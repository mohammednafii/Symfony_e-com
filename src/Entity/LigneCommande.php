<?php

namespace App\Entity;

use App\Repository\LigneCommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LigneCommandeRepository::class)]
class LigneCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $quantite = null;

    /**
     * @var Collection<int, Livre>
     */
    
     #[ORM\ManyToMany(targetEntity: Livre::class, inversedBy: 'ligneCommandes')]
    private Collection $Id_livre;

    /**
     * @var Collection<int, Commande>
     */
    #[ORM\ManyToMany(targetEntity: Commande::class, inversedBy: 'ligneCommandes')]
    private Collection $id_commande;

    /**
     * @var Collection<int, livre>
     */
    #[ORM\OneToMany(targetEntity: livre::class, mappedBy: 'ligneCommande')]
    private Collection $livre;

    #[ORM\Column]
    private ?float $price = null;

    public function __construct()
    {
        $this->Id_livre = new ArrayCollection();
        $this->id_commande = new ArrayCollection();
        $this->livre = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getQuantite(): ?string
    {
        return $this->quantite;
    }

    public function setQuantite(string $quantite): static
    {
        $this->quantite = $quantite;
        return $this;
    }

    /**
     * @return Collection<int, Livre>
     */
    public function getIdLivre(): Collection
    {
        return $this->Id_livre;
    }

    public function addIdLivre(Livre $idLivre): static
    {
        if (!$this->Id_livre->contains($idLivre)) {
            $this->Id_livre->add($idLivre);
        }

        return $this;
    }

    public function removeIdLivre(Livre $idLivre): static
    {
        $this->Id_livre->removeElement($idLivre);

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getIdCommande(): Collection
    {
        return $this->id_commande;
    }

    public function addIdCommande(Commande $idCommande): static
    {
        if (!$this->id_commande->contains($idCommande)) {
            $this->id_commande->add($idCommande);
        }

        return $this;
    }

    public function removeIdCommande(Commande $idCommande): static
    {
        $this->id_commande->removeElement($idCommande);

        return $this;
    }

    /**
     * @return Collection<int, livre>
     */
    public function getLivre(): Collection
    {
        return $this->livre;
    }
    

    public function addLivre(livre $livre): static
    {
        if (!$this->livre->contains($livre)) {
            $this->livre->add($livre);
            $livre->setLigneCommande($this);
        }

        return $this;
    }

    public function removeLivre(livre $livre): static
    {
        if ($this->livre->removeElement($livre)) {
            // set the owning side to null (unless already changed)
            if ($livre->getLigneCommande() === $this) {
                $livre->setLigneCommande(null);
            }
        }

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }
}
