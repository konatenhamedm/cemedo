<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ResponsableAssuranceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ResponsableAssuranceRepository::class)
 */
class ResponsableAssurance extends User
{
    /**
     * @ORM\ManyToOne(targetEntity=Assurance::class, inversedBy="responsableAssurances")
     */
    private $assurance;

    public function getAssurance(): ?Assurance
    {
        return $this->assurance;
    }

    public function setAssurance(?Assurance $assurance): self
    {
        $this->assurance = $assurance;

        return $this;
    }
}
