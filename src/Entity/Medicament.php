<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MedicamentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 * )
 * @ORM\Entity(repositoryClass=MedicamentRepository::class)
 */
class Medicament
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"assures_read","facture_read","ordonnance_read"})
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Ordonnance::class, mappedBy="medicament")
     */
    private $ordonnances;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"assures_read","facture_read","ordonnance_read"})
     */
    private $quantite;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"assures_read","facture_read","ordonnance_read"})
     */
    private $posologie;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"assures_read","facture_read","ordonnance_read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     * @Groups({"assures_read","facture_read","ordonnance_read"})
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"assures_read","facture_read","ordonnance_read"})
     */
    private $version;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"assures_read","facture_read","ordonnance_read"})
     */
    private $active;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;


    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function setVersion(int $version): self
    {
        $this->version = $version;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function __construct()
    {
        $this->ordonnances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Ordonnance>
     */
    public function getOrdonnances(): Collection
    {
        return $this->ordonnances;
    }

    public function addOrdonnance(Ordonnance $ordonnance): self
    {
        if (!$this->ordonnances->contains($ordonnance)) {
            $this->ordonnances[] = $ordonnance;
            $ordonnance->setMedicament($this);
        }

        return $this;
    }

    public function removeOrdonnance(Ordonnance $ordonnance): self
    {
        if ($this->ordonnances->removeElement($ordonnance)) {
            // set the owning side to null (unless already changed)
            if ($ordonnance->getMedicament() === $this) {
                $ordonnance->setMedicament(null);
            }
        }

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPosologie(): ?string
    {
        return $this->posologie;
    }

    public function setPosologie(string $posologie): self
    {
        $this->posologie = $posologie;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }
}
