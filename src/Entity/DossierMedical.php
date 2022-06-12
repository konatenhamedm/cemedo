<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DossierMedicalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=DossierMedicalRepository::class)
 */
class DossierMedical
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Assure::class, inversedBy="dossierMedicals")
     */
    private $assure;

    /**
     * @ORM\OneToMany(targetEntity=FichierMedical::class, mappedBy="dossier")
     */
    private $fichierMedicals;

    public function __construct()
    {
        $this->fichierMedicals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAssure(): ?Assure
    {
        return $this->assure;
    }

    public function setAssure(?Assure $assure): self
    {
        $this->assure = $assure;

        return $this;
    }

    /**
     * @return Collection<int, FichierMedical>
     */
    public function getFichierMedicals(): Collection
    {
        return $this->fichierMedicals;
    }

    public function addFichierMedical(FichierMedical $fichierMedical): self
    {
        if (!$this->fichierMedicals->contains($fichierMedical)) {
            $this->fichierMedicals[] = $fichierMedical;
            $fichierMedical->setDossier($this);
        }

        return $this;
    }

    public function removeFichierMedical(FichierMedical $fichierMedical): self
    {
        if ($this->fichierMedicals->removeElement($fichierMedical)) {
            // set the owning side to null (unless already changed)
            if ($fichierMedical->getDossier() === $this) {
                $fichierMedical->setDossier(null);
            }
        }

        return $this;
    }
}
