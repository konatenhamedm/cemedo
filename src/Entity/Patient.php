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
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @Vich\Uploadable()
 *@ApiResource(
 *      denormalizationContext={"groups"= {"write"}},
 *   collectionOperations={
 *     "get",
 *  "image_pharmacien" = {
 *       "method"="post",
 *       "path"="/pharmaciens/{id}/update",
 *       "controller" ="App\Controller\DefaultController",
 *       "openapi_context" = {
 *         "requestBody" = {
 *           "description" = "File Upload",
 *           "required" = true,
 *           "content" = {
 *             "multipart/form-data" = {
 *               "schema" = {
 *                 "type" = "object",
 *                 "properties" = {
 *                   "file" = {
 *                     "type" = "string",
 *                     "format" = "binary",
 *                     "description" = "File to be uploaded",
 *                   },
 *                 },
 *               },
 *             },
 *           },
 *         },
 *       },
 *     },
 *   },
 *     itemOperations={"GET"={"path"="/pharmaciens/{id}/update"},
 *     "DELETE"},
 *     denormalizationContext={"disable_type_enforcement"=true},
 * )
 * @ORM\Entity(repositoryClass=PatientRepository::class)
 */
class Patient extends Assure
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"assures_read","familles_read"})
     */
    private $id;



    /**
     * @var File|null
     * @Vich\UploadableField(mapping="fichiers",fileNameProperty="pieceIdRecto")
     * @Groups({"write"})
     */
    private $file ;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="fichiers",fileNameProperty="pieceIdVerso")
     * @Groups({"write"})
     */
    private $filePieceVerso ;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="fichiers",fileNameProperty="assuranceRecto")
     * @Groups({"write"})
     */
    private $fileAssuranceRecto ;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="fichiers",fileNameProperty="assuranceVerso")
     * @Groups({"write"})
     */
    private $fileAssuranceVerso ;


    /**
     * @return File|null
     */
    public function getFile(): ?File
    {
        return $this->file;
    }

    /**
     * @return File|null
     */
    public function getFilePieceVerso(): ?File
    {
        return $this->filePieceVerso;
    }
    /**
     * @return File|null
     */
    public function getFileAssuranceRecto(): ?File
    {
        return $this->fileAssuranceRecto;
    }
    /**
     * @return File|null
     */
    public function getFileAssuranceVerso(): ?File
    {
        return $this->fileAssuranceVerso;
    }

    /**
     * @param File|null $file
     * @return Patient
     */
    public function setFile(?File $file): Patient
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @param File|null $file
     * @return Patient
     */
    public function setFilePieceVerso(?File $file): Patient
    {
        $this->filePieceVerso = $file;
        return $this;
    }

    /**
     * @param File|null $file
     * @return Patient
     */
    public function setFileAssuranceRecto(?File $file): Patient
    {
        $this->fileAssuranceVerso = $file;
        return $this;
    }

    /**
     * @param File|null $file
     * @return Patient
     */
    public function setFileAssuranceVerso(?File $file): Patient
    {
        $this->fileAssuranceVerso = $file;
        return $this;
    }


    /**
     *
     * @Groups({"assures_read","familles_read"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pieceIdRecto;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"assures_read","familles_read"})
     */
    private $pieceIdVerso;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Groups({"assures_read","familles_read"})
     */
    private $assuranceRecto;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Groups({"assures_read","familles_read"})
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
