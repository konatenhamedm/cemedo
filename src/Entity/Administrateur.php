<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AdministrateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=AdministrateurRepository::class)
 */
class Administrateur extends User
{
    /**
     * @ORM\OneToMany(targetEntity=Facture::class, mappedBy="administrateur")
     */
    private $factures;

    public function __construct()
    {
        parent::__construct();
        $this->factures = new ArrayCollection();
    }

    /**
     * @return Collection<int, Facture>
     */
    public function getFactures(): Collection
    {
        return $this->factures;
    }

    public function addFacture(Facture $facture): self
    {
        if (!$this->factures->contains($facture)) {
            $this->factures[] = $facture;
            $facture->setAdministrateur($this);
        }

        return $this;
    }

    public function removeFacture(Facture $facture): self
    {
        if ($this->factures->removeElement($facture)) {
            // set the owning side to null (unless already changed)
            if ($facture->getAdministrateur() === $this) {
                $facture->setAdministrateur(null);
            }
        }

        return $this;
    }
}
