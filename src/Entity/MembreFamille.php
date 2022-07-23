<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use App\Repository\MembreFamilleRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *      normalizationContext={
 *      "groups"= {"familles_read"}
 *          }
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
     *@Groups({"familles_read"})
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Groups({"familles_read"})
     */
    private $relation;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class, inversedBy="membresFamille")
     */
    private $patient;

    public function getRelation(): ?string
    {
        return $this->relation;
    }

    public function setRelation(string $relation): self
    {
        $this->relation = $relation;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

}
