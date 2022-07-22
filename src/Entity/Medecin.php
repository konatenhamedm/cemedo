<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MedecinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=MedecinRepository::class)
 * @Vich\Uploadable()
 *@ApiResource(
 *   normalizationContext={"groups"= {"medecins_read"}},
 *     denormalizationContext={"groups"= {"write"}},
 *   collectionOperations={
 *     "get",
 *  "image_medecin" = {
 *       "method"="post",
 *       "path"="/medecins/{id}/update",
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
 *     itemOperations={"GET"={"path"="/medecins/{id}/update"},
 *     "DELETE"},
 * )
 */
class Medecin extends User
{
    /**
     * @ORM\Column(type="float" ,nullable=true)
     *  @Groups({"medecins_read","assures_read","read"})
     */
    private $salaireMedecin;

    /**
     * @ORM\OneToMany(targetEntity=RendezVous::class, mappedBy="medecin")
     * @Groups({"medecins_read"})
     */
    private $rendezVouses;

    /**
     * @ORM\ManyToOne(targetEntity=TypeMedecin::class, inversedBy="medecins")
     * @Groups({"medecins_read","assures_read","write","read"})
     */
    private $typeMedecin;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"medecins_read","assures_read","write"})
     */
    private $specialiteMedecin;

    /**
     * @ORM\Column(type="float" ,nullable=true)
     * @Groups({"medecins_read","assures_read","read"})
     */
    private $primeMedecin;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"medecins_read","assures_read","write","read"})
     */
    private $heureDebut;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"medecins_read","assures_read","write","read"})
     */
    private $heureFin;


    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Groups({"medecins_read","assures_read"})
     */
    private $photoMedecin;


    public function getPhotoMedecin(): ?string
    {
        return $this->photoMedecin;
    }

    public function setPhotoMedecin(?string $photoMedecin): self
    {
        $this->photoMedecin = $photoMedecin;

        return $this;
    }
    /**
     * @var File|null
     * @Vich\UploadableField(mapping="fichiers",fileNameProperty="photoMedecin")
     * @Groups({"write"})
     */
    private $file ;


    /**
     * @return File|null
     */
    public function getFile(): ?File
    {
        return $this->file;
    }

    /**
     *
     * @param File|null $file
     * @return Medecin
     */
    public function setFile(?File $file): Medecin
    {
        $this->file = $file;
        return $this;
    }

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

    public function getSepecialiteMedecin(): ?string
    {
        return $this->specialiteMedecin;
    }

    public function setSepecialiteMedecin(string $specialiteMedecin): self
    {
        $this->specialiteMedecin = $specialiteMedecin;

        return $this;
    }

    public function getPrimeMedecin(): ?float
    {
        return $this->primeMedecin;
    }

    public function setPrimeMedecin(float $primeMedecin): self
    {
        $this->primeMedecin = $primeMedecin;

        return $this;
    }

    public function getHeureDebut(): ?\DateTimeInterface
    {
        return $this->heureDebut;
    }

    public function setHeureDebut(\DateTimeInterface $heureDebut): self
    {
        $this->heureDebut = $heureDebut;

        return $this;
    }

    public function getHeureFin(): ?\DateTimeInterface
    {
        return $this->heureFin;
    }

    public function setHeureFin(\DateTimeInterface $heureFin): self
    {
        $this->heureFin = $heureFin;

        return $this;
    }


}
