<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\InfirmierRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=InfirmierRepository::class)
 */
class Infirmier extends User
{


    /**
     * @ORM\Column(type="float")
     */
    private $salaireInfirmier;


    public function getSalaireInfirmier(): ?float
    {
        return $this->salaireInfirmier;
    }

    public function setSalaireInfirmier(float $salaireInfirmier): self
    {
        $this->salaireInfirmier = $salaireInfirmier;

        return $this;
    }
}
