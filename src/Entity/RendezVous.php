<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RendezVousRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=RendezVousRepository::class)
 */
class RendezVous
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"assures_read","medecins_read"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Gerant::class, inversedBy="rendezVouses")
     * @Groups({"assures_read","medecins_read"})
     */
    private $gerant;

    /**
     * @ORM\ManyToOne(targetEntity=Assure::class, inversedBy="rendezVouses")
     *
     */
    private $concerne;

    /**
     * @ORM\ManyToOne(targetEntity=Medecin::class, inversedBy="rendezVouses")
     * @Groups({"assures_read"})
     */
    private $medecin;

    /**
     * @ORM\ManyToOne(targetEntity=Service::class, inversedBy="rendezVouses")
     * @Groups({"assures_read","medecins_read"})
     */
    private $service;

    /**
     * @ORM\ManyToOne(targetEntity=Adresse::class, inversedBy="rendezVouses")
     */
    private $adresse;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"assures_read","medecins_read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     * @Groups({"assures_read","medecins_read"})
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"assures_read","medecins_read"})
     */
    private $version;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"assures_read","medecins_read"})
     */
    private $active;

    /**
     * @Groups({"medecins_read"})
     * @ORM\OneToMany(targetEntity=Patient::class, mappedBy="rendezVous")
     */
    private $emetteur;

    public function __construct()
    {
        $this->emetteur = new ArrayCollection();
    }


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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGerant(): ?Gerant
    {
        return $this->gerant;
    }

    public function setGerant(?Gerant $gerant): self
    {
        $this->gerant = $gerant;

        return $this;
    }


    public function getConcerne(): ?Assure
    {
        return $this->concerne;
    }

    public function setConcerne(?Assure $concerne): self
    {
        $this->concerne = $concerne;

        return $this;
    }

    public function getMedecin(): ?Medecin
    {
        return $this->medecin;
    }

    public function setMedecin(?Medecin $medecin): self
    {
        $this->medecin = $medecin;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(?Adresse $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return Collection<int, Patient>
     */
    public function getEmetteur(): Collection
    {
        return $this->emetteur;
    }

    public function addEmetteur(Patient $emetteur): self
    {
        if (!$this->emetteur->contains($emetteur)) {
            $this->emetteur[] = $emetteur;
            $emetteur->setRendezVous($this);
        }

        return $this;
    }

    public function removeEmetteur(Patient $emetteur): self
    {
        if ($this->emetteur->removeElement($emetteur)) {
            // set the owning side to null (unless already changed)
            if ($emetteur->getRendezVous() === $this) {
                $emetteur->setRendezVous(null);
            }
        }

        return $this;
    }
}
