<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TypeFichierMedicalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=TypeFichierMedicalRepository::class)
 */
class TypeFichierMedical
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=FichierMedical::class, mappedBy="typeFichier")
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

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

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
            $fichierMedical->setTypeFichier($this);
        }

        return $this;
    }

    public function removeFichierMedical(FichierMedical $fichierMedical): self
    {
        if ($this->fichierMedicals->removeElement($fichierMedical)) {
            // set the owning side to null (unless already changed)
            if ($fichierMedical->getTypeFichier() === $this) {
                $fichierMedical->setTypeFichier(null);
            }
        }

        return $this;
    }
}
