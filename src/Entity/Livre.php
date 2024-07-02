<?php

namespace App\Entity;

use App\Repository\LivreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivreRepository::class)]
class Livre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(length: 255)]
    private ?string $nom = null;



    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $annee = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'livres')]
    private Collection $id_user;

    /**
     * @var Collection<int, Auteur>
     */
    #[ORM\OneToMany(targetEntity: Auteur::class, mappedBy: 'livre')]
    private Collection $id_auteur;

    /**
     * @var Collection<int, Langue>
     */
    #[ORM\OneToMany(targetEntity: Langue::class, mappedBy: 'livre', orphanRemoval: true)]
    private Collection $id_langue;

   

    /**
     * @var Collection<int, LigneCommande>
     */
    #[ORM\ManyToMany(targetEntity: LigneCommande::class, mappedBy: 'Id_livre')]
    private Collection $ligneCommandes;

    /**
     * @var Collection<int, Review>
     */

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageUrl = null;

    #[ORM\ManyToOne(inversedBy: 'livre')]
    private ?Categorie $categorie = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\ManyToOne(inversedBy: 'livre')]
    private ?LigneCommande $ligneCommande = null;

    #[ORM\ManyToOne(inversedBy: 'livres')]
    private ?Auteur $auteur = null;

    #[ORM\ManyToOne(inversedBy: 'livres')]
    private ?Langue $Langue = null;

    #[ORM\ManyToOne(inversedBy: 'livres')]
    private ?Review $review = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $pageNum = null;

    public function __construct()
    {
        $this->id_user = new ArrayCollection();
        $this->id_auteur = new ArrayCollection();
        $this->id_langue = new ArrayCollection();
        $this->ligneCommandes = new ArrayCollection();
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
    public function __toString(): string
    {
        return $this->nom;
    }
    public function getAnnee(): ?\DateTimeInterface
    {
        return $this->annee;
    }

    public function setAnnee(\DateTimeInterface $annee): static
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getIdUser(): Collection
    {
        return $this->id_user;
    }

    public function addIdUser(User $idUser): static
    {
        if (!$this->id_user->contains($idUser)) {
            $this->id_user->add($idUser);
        }

        return $this;
    }

    public function removeIdUser(User $idUser): static
    {
        $this->id_user->removeElement($idUser);

        return $this;
    }

    /**
     * @return Collection<int, Auteur>
     */
    public function getIdAuteur(): Collection
    {
        return $this->id_auteur;
    }

    public function addIdAuteur(Auteur $idAuteur): static
    {
        if (!$this->id_auteur->contains($idAuteur)) {
            $this->id_auteur->add($idAuteur);
            $idAuteur->setLivre($this);
        }

        return $this;
    }

    public function removeIdAuteur(Auteur $idAuteur): static
    {
        if ($this->id_auteur->removeElement($idAuteur)) {
            // set the owning side to null (unless already changed)
            if ($idAuteur->getLivre() === $this) {
                $idAuteur->setLivre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Langue>
     */
    public function getIdLangue(): Collection
    {
        return $this->id_langue;
    }

    public function addIdLangue(Langue $idLangue): static
    {
        if (!$this->id_langue->contains($idLangue)) {
            $this->id_langue->add($idLangue);
            $idLangue->setLivre($this);
        }

        return $this;
    }

    public function removeIdLangue(Langue $idLangue): static
    {
        if ($this->id_langue->removeElement($idLangue)) {
            // set the owning side to null (unless already changed)
            if ($idLangue->getLivre() === $this) {
                $idLangue->setLivre(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection<int, LigneCommande>
     */
    public function getLigneCommandes(): Collection
    {
        return $this->ligneCommandes;
    }

    public function addLigneCommande(LigneCommande $ligneCommande): static
    {
        if (!$this->ligneCommandes->contains($ligneCommande)) {
            $this->ligneCommandes->add($ligneCommande);
            $ligneCommande->addIdLivre($this);
        }

        return $this;
    }

    public function removeLigneCommande(LigneCommande $ligneCommande): static
    {
        if ($this->ligneCommandes->removeElement($ligneCommande)) {
            $ligneCommande->removeIdLivre($this);
        }

        return $this;
    }
    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $imageUrl): static
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

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

    public function getLigneCommande(): ?LigneCommande
    {
        return $this->ligneCommande;
    }

    public function setLigneCommande(?LigneCommande $ligneCommande): static
    {
        $this->ligneCommande = $ligneCommande;

        return $this;
    }
    public function getAuteur(): ?Auteur
    {
        return $this->auteur;
    }

    public function setAuteur(?Auteur $auteur): static
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getLangue(): ?Langue
    {
        return $this->Langue;
    }

    public function setLangue(?Langue $Langue): static
    {
        $this->Langue = $Langue;

        return $this;
    }

    public function getReview(): ?Review
    {
        return $this->review;
    }

    public function setReview(?Review $review): static
    {
        $this->review = $review;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPageNum(): ?int
    {
        return $this->pageNum;
    }

    public function setPageNum(int $pageNum): static
    {
        $this->pageNum = $pageNum;

        return $this;
    }
    
}
