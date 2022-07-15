<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PatientRepository;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *   collectionOperations={
 *     "get",
 *     "post" = {
 *       "controller" ="App\Controller\DefaultController",
 *       "deserialize" = false,
 *        "openapi_context" = {
 *         "requestBody" = {
 *           "description" = "File upload to an existing resource (superheroes)",
 *           "required" = true,
 *           "content" = {
 *             "multipart/form-data" = {
 *               "schema" = {
 *                 "type" = "object",
 *                 "properties" = {
 *                   "password" = {
 *                     "description" = "The name of the superhero",
 *                     "type" = "string",
 *                     "example" = "Clark Kent",
 *                   },
 *                   "tel" = {
 *                     "description" = "The name of the superhero",
 *                     "type" = "string",
 *                     "example" = "Clark Kent",
 *                   },
 *                   "pieceIdRecto" = {
 *                     "type" = "string",
 *                     "format" = "binary",
 *                     "description" = "Upload a cover image of the superhero",
 *                   },
 *                    "pieceIdVerso" = {
 *                     "type" = "string",
 *                     "format" = "binary",
 *                     "description" = "Upload a cover image of the superhero",
 *                   },
 *                 },
 *               },
 *             },
 *           },
 *         },
 *       },
 *     },
 *   },
 * )
 * @ORM\Entity(repositoryClass=PatientRepository::class)
 */
class Patient extends Assure
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"assures_read"})
     */
    private $id;

    /**
     * @var File null
     * @Groups({"assures_read"})
     * @ORM\Column(type="string", length=255, nullable=true)
     * @ApiProperty(
     *   iri="http://schema.org/image",
     *   attributes={
     *     "openapi_context"={
     *       "type"="string",
     *     }
     *   }
     * )
     */
    private $pieceIdRecto;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pieceIdVerso;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $assuranceRecto;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $assuranceVerso;

    /**
     * @ORM\ManyToOne(targetEntity=RendezVous::class, inversedBy="emetteur")
     */
    private $rendezVous;

    /**
     * @Groups({"assures_read"})
     * @ORM\OneToMany(targetEntity=MembreFamille::class, mappedBy="patient")
     */
    private $membresFamille;


    public function getPieceIdRecto(): ?string
    {
        return $this->pieceIdRecto;
    }

    public function setPieceIdRecto(?string $pieceIdRecto): self
    {
        $this->pieceIdRecto = $pieceIdRecto;

        return $this;
    }

    public function getPieceIdVerso(): ?string
    {
        return $this->pieceIdVerso;
    }

    public function setPieceIdVerso(?string $pieceIdVerso): self
    {
        $this->pieceIdVerso = $pieceIdVerso;

        return $this;
    }

    public function getAssuranceRecto(): ?string
    {
        return $this->assuranceRecto;
    }

    public function setAssuranceRecto(string $assuranceRecto): self
    {
        $this->assuranceRecto = $assuranceRecto;

        return $this;
    }

    public function getAssuranceVerso(): ?string
    {
        return $this->assuranceVerso;
    }

    public function setAssuranceVerso(string $assuranceVerso): self
    {
        $this->assuranceVerso = $assuranceVerso;

        return $this;
    }

    public function getRendezVous(): ?RendezVous
    {
        return $this->rendezVous;
    }

    public function setRendezVous(?RendezVous $rendezVous): self
    {
        $this->rendezVous = $rendezVous;

        return $this;
    }

    /**
     * @return Collection<int, MembreFamille>
     */
    public function getMembresFamille(): Collection
    {
        return $this->membresFamille;
    }

    public function addMembreFamille(MembreFamille $membreFamille): self
    {
        if (!$this->membresFamille->contains($membreFamille)) {
            $this->membresFamille[] = $membreFamille;
            $membreFamille->setPatient($this);
        }

        return $this;
    }

    public function removeMembreFamille(MembreFamille $membreFamille): self
    {
        if ($this->membresFamille->removeElement($membreFamille)) {
            // set the owning side to null (unless already changed)
            if ($membreFamille->getPatient() === $this) {
                $membreFamille->setPatient(null);
            }
        }

        return $this;
    }
}
