<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MedecinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *       normalizationContext={
 *      "groups"= {"medecins_read"}
 *          }
 * )
 * @ORM\Entity(repositoryClass=MedecinRepository::class)
 */
class Medecin extends User
{
    /**
     * @ORM\Column(type="float")
     *  @Groups({"medecins_read"})
     */
    private $salaireMedecin;

    /**
     * @ORM\OneToMany(targetEntity=RendezVous::class, mappedBy="medecin")
     * @Groups({"medecins_read"})
     */
    private $rendezVouses;

    /**
     * @ORM\ManyToOne(targetEntity=TypeMedecin::class, inversedBy="medecins")
     * @Groups({"medecins_read"})
     */
    private $typeMedecin;

    public function __construct()
    {
        $this->rendezVouses = new ArrayCollection();
    }


    public function getSalaireMedecin(): ?float
    {
        return $this->salaireMedecin;
    }

    public function setSalaireMedecin(float $salaireMedecin): self
    {
        $this->salaireMedecin = $salaireMedecin;

        return $this;
    }

    /**
     * @return Collection<int, RendezVous>
     */
    public function getRendezVouses(): Collection
    {
        return $this->rendezVouses;
    }

    public function addRendezVouse(RendezVous $rendezVouse): self
    {
        if (!$this->rendezVouses->contains($rendezVouse)) {
            $this->rendezVouses[] = $rendezVouse;
            $rendezVouse->setMedecin($this);
        }

        return $this;
    }

    public function removeRendezVouse(RendezVous $rendezVouse): self
    {
        if ($this->rendezVouses->removeElement($rendezVouse)) {
            // set the owning side to null (unless already changed)
            if ($rendezVouse->getMedecin() === $this) {
                $rendezVouse->setMedecin(null);
            }
        }

        return $this;
    }

    public function getTypeMedecin(): ?TypeMedecin
    {
        return $this->typeMedecin;
    }

    public function setTypeMedecin(?TypeMedecin $typeMedecin): self
    {
        $this->typeMedecin = $typeMedecin;

        return $this;
    }
}
