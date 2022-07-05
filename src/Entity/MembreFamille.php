<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use App\Repository\MembreFamilleRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource(
 * )
 * @ORM\Entity(repositoryClass=MembreFamilleRepository::class)
 */
#[ApiFilter(SearchFilter::class, properties: ['patient' => 2])]
class MembreFamille extends Assure
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class, inversedBy="membreFamilles")
     */
    private $patient;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $relation;

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    public function getRelation(): ?string
    {
        return $this->relation;
    }

    public function setRelation(string $relation): self
    {
        $this->relation = $relation;

        return $this;
    }
}
